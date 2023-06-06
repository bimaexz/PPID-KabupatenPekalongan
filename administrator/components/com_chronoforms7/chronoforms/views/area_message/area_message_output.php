<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$view['nodes']['main']['attrs']['id'] = $view['name'];
	if(!empty($view['nodes']['icon']['attrs']['class']['icon'])){
		$view['nodes']['main']['attrs']['class']['icon'] = 'icon';
	}
	$_map = [
		'content' => ['active' => true, 'content' => $this->Parser->section($view['uid'].'/body'), 'attrs' => ['class' => ['content']]],
		'title' => ['tag' => 'div'],
		'main' => ['tag' => 'div', 'children' => ['title', 'icon', 'content'], 'attrs' => ['class' => ['ui message']]],
	];

	echo $this->Field->build($view, $_map);
?>