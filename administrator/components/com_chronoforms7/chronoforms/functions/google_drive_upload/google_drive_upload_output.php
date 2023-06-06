<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$gclient = [];

	$UserServiceAccount = new \G3\A\M\UserServiceAccount();
	$account = $UserServiceAccount->where('account_id', $function['account_id'])->select('first', ['json' => ['params']]);

	$gclient = $account['UserServiceAccount']['params'];

	$return = [];
	
	if(!empty($gclient)){
		$this->debug[$function['name']]['token'] = rl3('Access token found');


		$drive = new \G3\L\Services\Google\Drive([
			'token' => $gclient['token'], 
			'scopes' => ['https://www.googleapis.com/auth/drive'], 
			'credentials' => $gclient['credentials'],
		]);

		if(!empty($function['files'])){
			foreach($function['files'] as $vuid => $files){
				foreach($files as $kp => $file){
					$filedata = fopen($file['path'], 'r');
					$metadata = [
						'name' => basename($file['path']),
						'parents' => !empty($function['metadata']['parent']) ? [$function['metadata']['parent']] : [],
					];

					// $return[$file['fieldname']][$kp] = $drive->upload($metadata, $filedata);
					$return = \G3\L\Arr::setVal($return, $file['fieldname'], $drive->upload($metadata, $filedata));
					if(empty(\G3\L\Arr::getVal($return, $file['fieldname']))){
						$this->errors = array_merge($this->errors, $drive->errors);
						$this->debug[$function['name']][$file['fieldname']] = $drive->msgs;
					}
				}
			}
		}
	}else{
		$this->debug[$function['name']]['token'] = rl3('Error getting access token');
	}
	
	// if(!empty($_errors)){
	// 	$this->messages['error'][$function['name']] = $_errors;
	// 	$_result = false;
	// }
	
	if($return === false){
		$this->fevents[$function['name']]['fail'] = true;
	}else{
		$this->fevents[$function['name']]['success'] = true;
	}

	$this->set($function['name'], $return);