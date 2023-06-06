<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$grid_classes = [
		'' => '',
		'equal' => 'equal width',
		1 => 'one',
		2 => 'two',
		3 => 'three',
		4 => 'four',
		5 => 'five',
		6 => 'six',
		7 => 'seven',
		8 => 'eight',
		9 => 'nine',
		10 => 'ten',
		11 => 'eleven',
		12 => 'twelve',
		13 => 'thirteen',
		14 => 'fourteen',
		15 => 'fifteen',
	];

	$contents = [];
	if(!empty($view['areas']) AND is_array($view['areas'])){
		
		foreach($view['rows'] as $rk => $row){
			$classes = [];
			$classes[] = !empty($row['column_count']) ? $grid_classes[$row['column_count']].' column' : '';
			$classes[] = $row['class'];
			$classes[] = $row['stretched'];
			$classes[] = $row['centered'];
			$classes[] = !empty($row['valign']) ? $row['valign'].' aligned' : '';
			$row_class = implode(' ', array_filter($classes));
			
			$contents[] = '<div class="row '.$row_class.'">';
			if(!empty($row['columns'])){
				foreach($row['columns'] as $ck => $column){
					$section_name = $view['areas'][$rk.'_'.$ck]['name'];
					$classes = [];
					$classes[] = $section_name;
					$classes[] = !empty($column['width']) ? $grid_classes[$column['width']].' wide' : '';
					$classes[] = $column['class'];
					$classes[] = $column['floating'];
					$classes[] = !empty($column['halign']) ? $column['halign'].' aligned' : '';
					$column_class = implode(' ', array_filter($classes));
					
					$contents[] = '<div class="column '.$column_class.'">';
					$contents[] = $this->Parser->section($view['uid'].'/'.$section_name);
					$contents[] = '</div>';
				}
			}
			$contents[] = '</div>';
		}
	}

	$view['nodes']['main']['attrs']['id'] = $view['name'];
	$_map = [
		'main' => ['tag' => 'div', 'content' => implode('', $contents), 'attrs' => ['class' => ['ui grid']]],
	];

	echo $this->Field->build($view, $_map);