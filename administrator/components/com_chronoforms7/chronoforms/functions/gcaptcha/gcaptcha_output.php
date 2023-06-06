<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$site_key = $this->controller->FData->cdata('settings.form.gcaptcha.sitekey') ?? $this->get('cf_settings.gcaptcha.sitekey');
	if(empty($site_key)){
		return;
	}

	$function['secret_key'] = !empty($function['secret_key']) ? $function['secret_key'] : ($this->controller->FData->cdata('settings.form.gcaptcha.secretkey') ?? $this->get('cf_settings.gcaptcha.secretkey'));
	$function['failed_error'] = !empty($function['failed_error']) ? $function['failed_error'] : $this->get('cf_settings.gcaptcha.error');
	
	if(!empty($function['secret_key'])){
		
		if(ini_get('allow_url_fopen')){
			$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$function['secret_key'].'&response='.$this->data('g-recaptcha-response'));
		}else{
			$ch = curl_init('https://www.google.com/recaptcha/api/siteverify?secret='.$function['secret_key'].'&response='.$this->data('g-recaptcha-response'));
			curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
			curl_close($ch);
		}
		
		$response = json_decode($response, true);
		
		$this->debug[$function['name']]['response'] = $response;
		
		if($response['success'] === true){
			$this->debug[$function['name']]['_success'] = rl3('The reCaptcha verification was successfull.');
			$this->set($function['name'], true);
			$this->fevents[$function['name']]['success'] = true;
			return;
		}else{
			$this->errors[$function['name']][] = $this->Parser->parse($function['failed_error']);
			
			$this->debug[$function['name']]['_error'] = rl3('The reCaptcha verification has failed.');
			$this->set($function['name'], false);
			$this->fevents[$function['name']]['fail'] = true;
			return;
		}
		
	}else{
		$this->errors[$function['name']][] = $this->Parser->parse($function['failed_error']);
		
		$this->debug[$function['name']]['_error'] = rl3('No secret key is provided.');
		$this->set($function['name'], false);
		$this->fevents[$function['name']]['fail'] = true;
	}