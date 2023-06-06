<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(\GApp3::instance()->site != 'front'){
		return;
	}
	
	if(!empty($function['redirect'])){
		// $return = 'index.php?option=com_chronoforms7&chronoform='.$this->controller->FData->cdata('alias').'&gpage='.str_replace('::', '.', $this->controller->FData->sessiondata('pages.active'));
		$return = 'index.php?'.urldecode(http_build_query($_REQUEST));
		
		$joomlaLoginUrl = 'index.php?option=com_users&view=login&return='.urlencode(base64_encode($return));

		if(!empty($time)){
			\GApp3::document()->addHeaderTag('<meta http-equiv="refresh" content="'.$time.';url='.r3($joomlaLoginUrl).'" />');
		}else{
			\GApp3::redirect(r3($joomlaLoginUrl));
		}
	}else{
		$mainframe = \JFactory::getApplication();
		
		$credentials = array();
		$credentials['username'] = $this->Parser->parse(trim($function['username_provider']));
		$credentials['password'] = $this->Parser->parse(trim($function['password_provider']));
		
		if(!empty(array_filter($credentials))){
			if($mainframe->login($credentials) === true){
				$this->set($function['name'], true);
				$this->fevents[$function['name']]['success'] = true;
				$this->debug[$function['name']]['_success'] = rl3('User logged in successfully.');
			}else{
				$this->debug[$function['name']]['_error'] = rl3('User login failed.');
				$this->set($function['name'], false);
				$this->fevents[$function['name']]['fail'] = true;
			}
		}else{
			$this->debug[$function['name']]['_error'] = rl3('User login failed, missing credentials data');
			$this->set($function['name'], false);
			$this->fevents[$function['name']]['fail'] = true;
		}
	}