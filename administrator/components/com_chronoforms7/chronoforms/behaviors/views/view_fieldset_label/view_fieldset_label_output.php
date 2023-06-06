<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['nodes']['title']['content']) OR !empty($unit['nodes']['title']['attrs']['class']['icon'])){
		$unit['nodes']['title']['active'] = true;
	}

	$unit['nodes']['title']['attrs']['class']['default'] = 'ui label';
	
	if(!empty($unit['nodes']['title']['spacing'])){
		$unit['nodes']['title']['attrs']['style']['margin'] = 'margin-'.$unit['nodes']['title']['attrs']['class']['orientation'].':'.$unit['nodes']['title']['spacing'].';';
	}

	if(empty($unit['nodes']['title']['attrs']['class']['style'])){
		$unit['nodes']['title']['attrs']['class']['style'] = 'floating';
	}

	if($unit['nodes']['title']['attrs']['class']['style'] == 'floating'){
		$unit['nodes']['title']['attrs']['class']['aligned'] = 'aligned';
	}

	if(!empty($unit['nodes']['title']['attrs']['class']['icon'])){
		$unit['nodes']['title_icon']['active'] = true;
		$unit['nodes']['title_icon']['tag'] = 'i';
		$unit['nodes']['title_icon']['attrs']['class']['default'] = 'faicon';
		$unit['nodes']['title_icon']['attrs']['class']['icon'] = $unit['nodes']['title']['attrs']['class']['icon'];
		$unit['nodes']['title']['attrs']['class']['icon'] = '';
		$unit['nodes']['title']['children'] = ['title_icon', '__CONTENT__'];
	}