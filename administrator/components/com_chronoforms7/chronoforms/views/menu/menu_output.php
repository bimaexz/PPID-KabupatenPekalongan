<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$results = [];
	if(!empty($view['data_source'])){
		$results = $this->controller->FData->dsources($view['data_source']);
	}
	

	$column_class = function($area, $column, $header = [])use($view){
		$classes = [];

		if(!empty($view['active']) AND ($this->Parser->parse($view['active']) == $area['name'])){
			$classes[] = 'active';
		}

		$classes[] = \G3\L\Str::slug($area['name'], '-');
		// $classes[] = $column['width'].' '.($header['width'] ?? '');
		$classes[] = $column['class'].' '.($header['class'] ?? '');
		return implode(' ', array_filter($classes));
	};

	$contents = [];
	if(!empty($view['areas'])){
		foreach($view['areas'] as $sk => $column){
			if(!isset($view['items'][$sk])){
				continue;
			}
			
			$contents[] = '<div class="item '.$column_class($view['areas'][$sk], $view['items'][$sk]).'">';

			$content_found = $this->Parser->section($view['uid'].'/'.$view['areas'][$sk]['name']);

			if(!empty($content_found)){
				$contents[] = $content_found;
			}else{
				$contents[] = $view['items'][$sk]['title'];
			}

			$contents[] = '</div>';
		}
	}

	$table = implode('', $contents);

	$view['nodes']['main']['attrs']['id'] = $view['name'];

	$_map = [
		'main' => ['tag' => 'div', 'content' => $table, 'attrs' => ['class' => ['ui link menu']]],
	];

	echo $this->Field->build($view, $_map);