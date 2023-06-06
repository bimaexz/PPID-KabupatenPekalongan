<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$name = $this->Parser->parsev(trim($function['name_provider']));
	$username = $this->Parser->parsev(trim($function['username_provider']));
	$password = $this->Parser->parsev(trim($function['password_provider']));
	$email = $this->Parser->parsev(trim($function['email_provider']));
	// $block = $this->Parser->parse(trim($function['block_provider']));
	$status = $this->Parser->parse(trim($function['status']));

	$groups = [];
	if(!empty($function['groups_provider'])){
		foreach($function['groups_provider'] as $gid){
			$groups[] = $this->Parser->parse($gid);
		}
	}
	
	$userData = [
		'name' => trim($name),
		'username' => trim($username),
		'email' => $email,
		'password' => trim($password),
		'block' => ((int)($status >= 1)) ? 1 : 0,
		'activation' => ((int)($status >= 2)) ? \G3\L\Str::uuid() : '',
	];

	$this->set($function['name'].'_activation.token', $userData['activation']);
	
	if(!empty($function['data_override'])){
		$new_data = $function['data_override'];

		foreach($new_data as $new_data_line){
			$new_data_value = $this->Parser->parse($new_data_line['value']);
			$userData[$new_data_line['name']] = $new_data_value;
		}
	}
	
	if(!empty($userData['password'])){
		//$userData['password'] = JUserHelper::hashPassword($userData['password']);
	}
	
	if(empty($userData['id']) AND empty($function['where']['field']['name']) AND empty($userData['registerDate'])){
		$userData['registerDate'] = \G3\L\Dater::datetime('Y-m-d H:i:s');
	}
	
	foreach(['name', 'username', 'password', 'email'] as $req){
		if(isset($userData[$req]) AND empty($userData[$req])){
			if(!empty($function['where']['field']['name'])){
				unset($userData[$req]);
			}else{
				$this->debug[$function['name']]['_error'] = rl3('%s is missing', [$req]);
				$this->set($function['name'], false);
				$this->fevents[$function['name']]['fail'] = true;
				return;
			}
		}
	}
	
	$userModel = new \G3\A\M\User();
	
	if(empty($userData['id']) AND empty($function['where']['field']['name'])){
		//check if username/email are unique
		$exists = $userModel->where('username', $username)->where('OR')->where('email', $email)->select('first');
		
		if(!empty($exists)){
			if(!isset($function['userexists_error']) OR !empty($function['userexists_error'])){
				$this->errors[$function['name']][] = $this->Parser->parse($function['userexists_error']);
			}
			$this->debug[$function['name']]['_error'] = rl3('A user with the same username or email already exists.');
			$this->set($function['name'], false);
			$this->fevents[$function['name']]['user_exists'] = true;
			return;
		}
	}
	//save the user
	if(!empty($function['where']['field']['name']) AND !empty($function['where']['field']['value'])){

		$exists = $userModel->where($function['where']['field']['name'], trim($function['where']['field']['value']))->select('first');
		
		if(empty($exists)){
			$this->errors[$function['name']][] = $this->Parser->parse($function['usernotexists_error']);
			$this->debug[$function['name']]['_error'] = rl3('Could not find this user account');
			$this->set($function['name'], false);
			return;
		}

		$userModel->where($function['where']['field']['name'], trim($function['where']['field']['value']));
		$userSave = $userModel->update($userData);

		$userModel->id = $exists['User']['id'];
	}else{
		$userSave = $userModel->save($userData);
	}
	
	if($userSave !== false){
		$user_id = $userModel->id;
		$userData['id'] = $user_id;
		
		if(!empty($groups)){
			$groups = (array)$groups;
			$groups = array_filter(array_unique($groups));
			
			$userGroupModel = new \G3\A\M\GroupUser();

			$userGroupModel->where('user_id', $user_id)->delete();
			
			foreach($groups as $group){
				$groupSave = $userGroupModel->insert(['group_id' => $group, 'user_id' => $user_id]);
				
				if($groupSave === false){
					$this->debug[$function['name']]['_error'] = rl3('Error assignning the user to a group.');
					$this->set($function['name'], false);
					$this->fevents[$function['name']]['fail'] = true;
					return;
				}
			}
		}

		if(!empty($function['custom_fields'])){
			$FieldsTable = new \G3\L\Model(['name' => 'Field', 'table' => '#__fields_values']);
			
			foreach($function['custom_fields'] as $fid => $customField){
				$FieldsTable->where('field_id', $customField['id'])->where('item_id', $user_id)->delete();
				$FieldsTable->insert(['field_id' => $customField['id'], 'item_id' => $user_id, 'value' => $this->Parser->parsev($customField['value'])], ['duplicate_update' => true]);
			}
		}

		if(!empty($function['activationUrl'])){
			if(is_numeric($function['activationUrl'])){
				$function['activationUrl'] = r3(\G3\L\Url::build($this->Parser->_url(), ['gpage' => $this->controller->FData->cdata('pages.'.$function['activationUrl'].'.urlname'), 'uid' => $userData['id'], 'token' => $userData['activation']]), ['full' => true]);
			}
		}
		
		$this->set($function['name'].'_activation.link', $function['activationUrl']);
		
		$this->set($function['name'], $userData);
		$this->fevents[$function['name']]['success'] = true;
		$this->debug[$function['name']]['_success'] = rl3('User saved successfully under id %s', [$user_id]);
	}else{
		$this->debug[$function['name']]['_error'] = rl3('Error saving user.');
		$this->set($function['name'], false);
		$this->fevents[$function['name']]['fail'] = true;
		return;
	}