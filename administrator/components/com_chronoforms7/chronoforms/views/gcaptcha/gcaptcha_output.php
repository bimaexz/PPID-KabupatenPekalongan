<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$lang = $this->Parser->parse($view['lang'] ?? 'en');

	$view['site_key'] = $this->controller->FData->cdata('settings.form.gcaptcha.sitekey') ?? $this->get('cf_settings.gcaptcha.sitekey');

	$view['nodes']['main']['attrs']['id'] = $view['name'];
	$view['nodes']['main']['attrs']['data-sitekey'] = $view['site_key'];
	$view['nodes']['main']['attrs']['data-theme'] = $view['theme'] ?? 'light';
	$view['nodes']['main']['attrs']['class'] = 'g-recaptcha';
	
	$view['nodes']['container']['class']['req'] = 'required';

	if(!empty($view['gversion'])){
		unset($view['nodes']['main']['attrs']['data-sitekey']);
		$view['nodes']['main']['attrs']['data-sitekey3'] = $view['site_key'];
		$view['nodes']['container']['class']['hidden'] = 'hidden';
		$view['nodes']['main']['attrs']['class'] = 'g-recaptcha v3';
		$view['nodes']['main']['content'] = '';
	}

	if(empty($view['site_key'])){
		$view['nodes']['main']['content'] = '<label class="ui label red">'.rl3('The reCaptcha site key is missing').'</label>';
	}

	$_map = [
		'main' => ['tag' => 'div'],
		'container' => ['children' => ['label', 'main']],
	];

	echo $this->Field->build($view, $_map);


	$param = 'hl';
	if(!empty($view['gversion'])){
		$param = 'render';
		$lang = $view['site_key'];
	}
	
	if(empty(\GApp3::instance()->tvout)){
		\GApp3::document()->addJsFile('https://www.google.com/recaptcha/api.js?'.$param.'='.$lang);
	}else{
		echo '<script src="https://www.google.com/recaptcha/api.js?'.$param.'='.$lang.'"></script>';
	}