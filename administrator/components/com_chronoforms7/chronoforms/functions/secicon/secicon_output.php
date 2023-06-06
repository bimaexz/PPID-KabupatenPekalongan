<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	
	if(!empty($function['field_name'])){
		
		$sent = $this->data($function['field_name']);
		$stored = \GApp3::session()->get('secicon/'.$function['field_name']);
		
		if(!empty($stored) AND ($sent == $stored)){
			$this->debug[$function['name']]['_success'] = rl3('The security image verification was successfull.');
			$this->set($function['name'], true);
			$this->fevents[$function['name']]['success'] = true;
			\GApp3::session()->clear('secicon/'.$function['field_name']);
			return;
		}else{
			$this->errors[$function['name']][] = $this->Parser->parse($function['failed_error']);
			
			$this->debug[$function['name']]['_error'] = rl3('The security image verification has failed.');
			$this->set($function['name'], false);
			$this->fevents[$function['name']]['fail'] = true;
			\GApp3::session()->clear('secicon/'.$function['field_name']);
			return;
		}
		
	}else{
		$this->errors[$function['name']][] = $this->Parser->parse($function['failed_error']);
		
		$this->debug[$function['name']]['_error'] = rl3('The field name has not been provided.');
		$this->set($function['name'], false);
		$this->fevents[$function['name']]['fail'] = true;
	}