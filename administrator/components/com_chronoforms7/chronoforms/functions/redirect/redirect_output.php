<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(empty($function['pageurl'])){
		return;
	}
	
	$params = [];

	if(is_numeric($function['pageurl'])){
		$url = $this->Parser->_url();
		$params['gpage'] = $this->controller->FData->cdata('pages.'.$function['pageurl'].'.urlname');
	}else{
		$url = $this->Parser->parse($function['pageurl']);
	}
	
	if(!empty($function['parameters'])){
		foreach($function['parameters'] as $parameter){
			$params[$this->Parser->parse($parameter['name'])] = $this->Parser->parse($parameter['value']);
		}
	}
	
	$url = \G3\L\Url::build($url, $params);
	
	$time = 0;
	if(!empty($function['time'])){
		$time = $this->Parser->parse($function['time']);
	}

	if(empty($function['form_end_behavior'])){
		$active_page = $this->controller->FData->sessiondata('pages.active');
		$this->controller->Page->event_finish($active_page);
	}
	
	if(empty(\GApp3::instance()->tvout)){
		if(!empty($time)){
			\GApp3::document()->addHeaderTag('<meta http-equiv="refresh" content="'.$time.';url='.r3($url).'" />');
		}else{
			\GApp3::redirect(r3($url));
		}
	}else{
		echo '
		<script type="text/javascript">
			jQuery(document).ready(function($){
				setTimeout(function() {
					window.location = "'.r3($url, false, true).'";
				}, '.($time * 1000).');
			});
		</script>';
	}