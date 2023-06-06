<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$page = $this->controller->FData->sessiondata('pages.active');
	$pid = $page;//$this->controller->FData->cdata('pids.'.$page);

	$output = empty($view['uid']) ? $view['content'] : $this->Parser->section($view['uid'].'/body');

	if(!empty($view['uid'])){
		$page_settings = $this->controller->FData->cdata('pages.'.$pid.'.form', []);
		$form_settings = $this->controller->FData->cdata('settings.form.form', []);
		$view = array_merge($form_settings, $page_settings, $view);

		// $view['nodes']['main']['attrs']['class']['child'] = 'childform';
	}

	$view['nodes']['main']['attrs']['class']['default'] = 'ui form G3-form';

	$next_event = $this->controller->FData->cdata('pages.'.$this->controller->FData->cdata('pages.'.$pid.'.next_page')[0].'.urlname');

	$url = \G3\L\Url::build(\G3\L\Url::current(), ['chronoform' => $this->controller->FData->cdata('alias'), 'gpage' => $next_event]);

	if(!empty($view['absolute_url']) OR !empty($view['nodes']['main']['attrs']['class']['ajax'])){
		if(!empty($view['nodes']['main']['attrs']['class']['ajax'])){
			$url = \G3\L\Url::build($url, ['tvout' => 'view']);
		}
	}

	if(!empty($this->controller->FData->sessiondata('pages.tokens.'.$page, ''))){
		$output .= '<input type="hidden" name="__cf_token" data-ghost="1" data-cftoken="1" value="'.$this->controller->FData->sessiondata('pages.tokens.'.$page, '').'" />';
	}

	$attrs = [
		'action' => r3($url),
		'method' => 'post',
		'id' => $this->controller->FData->cdata('alias').'-'.$this->controller->FData->cdata('pages.'.$pid.'.fullname'),
		'class' => $view['nodes']['main']['attrs']['class'],
		'data-vmsgs' => "inlinetext",
		'enctype' => "multipart/form-data",
		'data-subanimation' => "1",
	];

	if(!empty($view['attrs'])){
		foreach($view['attrs'] as $attr){
			$attrs[$attr['name']] = $this->controller->Parser->parse($attr['value']);
		}
	}

	if(!empty($view['nodes']['main']['attrs']['action'])){
		if(is_numeric($view['nodes']['main']['attrs']['action'])){
			$next_event = $this->controller->FData->cdata('pages.'.$view['nodes']['main']['attrs']['action'].'.urlname');
			$view['nodes']['main']['attrs']['action'] = $this->controller->Parser->parse('{url:'.$next_event.'}');
		}
	}

	if(!empty($view['nodes']['main']['attrs'])){
		foreach($view['nodes']['main']['attrs'] as $key => $value){
			if(!empty($value)){
				$attrs[$key] = $this->controller->Parser->parse($value);
			}
		}
	}
	
	$Html = new \G3\H\Html();
	$output = $Html->node([
		'active' => true, 
		'tag' => 'form',
		'content' => $output,
		'attrs' => $attrs,
	]);

	echo $output;

	// echo $this->Field->build($view, $_map);
?>