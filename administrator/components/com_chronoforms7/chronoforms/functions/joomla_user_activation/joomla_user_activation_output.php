<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$activation = $this->Parser->parse(trim($function['activation_provider']));
	$block = $this->Parser->parse(trim($function['block_provider']));
	
	if(empty($activation)){
		$this->debug[$function['name']]['_error'] = rl3('Missing activation data.');
		$this->set($function['name'], false);
		$this->fevents[$function['name']]['fail'] = true;
		return;
	}
	
	$activation = trim($activation);
	
	$userModel = new \G3\A\M\User();
	//check if username/email are unique
	$exists = $userModel->where('activation', $activation)->select('first');
	
	if(empty($exists)){
		//$this->errors[$function['name']][] = rl3('The activation code does not exist or the account is already active.');
		$this->debug[$function['name']]['_error'] = rl3('A user with this activation code does not exist.');
		$this->set($function['name'], false);
		$this->fevents[$function['name']]['fail'] = true;
		return;
	}
	//save the user
	$userSave = $userModel->where('id', $exists['User']['id'])->update(['activation' => '', 'block' => $block]);
	
	if($userSave !== false){
		$this->set($function['name'], $exists['User']);
		$this->fevents[$function['name']]['success'] = true;
		$this->debug[$function['name']]['_success'] = rl3('User activated successfully.');
	}else{
		$this->debug[$function['name']]['_error'] = rl3('Error updating user account.');
		$this->set($function['name'], false);
		$this->fevents[$function['name']]['fail'] = true;
		return;
	}