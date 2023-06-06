<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['columns'],
		'items' => !empty($item['columns']) ? $item['columns'] : null,
		'visible' => ['columns' => 1],
		'parents' => !empty($parents) ? $parents : [],
		'inputs' => [
			'columns' => [
				'main' => [
					'r1' => [
						[
							'width' => 'three wide', 
							'params' => [
								'placeholder' => rl3('Name'), 
								'origin' => ['name' => 'Connection[views]['.$n.'][areas][#rows#_#columns#][name]', 'value' => 'row#rows#_column#columns#']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'select',
							'options' =>  [
								'' => rl3('Auto'),
								2 => rl3('Two'),
								3 => rl3('Three'),
								4 => rl3('Four'),
								5 => rl3('Five'),
								6 => rl3('Six'),
								7 => rl3('Seven'),
								8 => rl3('Eight'),
								9 => rl3('Nine'),
								10 => rl3('Ten'),
								11 => rl3('Eleven'),
								12 => rl3('Twelve'),
								13 => rl3('Thrteen'),
								14 => rl3('Fourteen'),
							],
							'desc' => rl3('Column width'),
							'params' => [
								'placeholder' => '',
								'origin' => ['name' => 'Connection[views]['.$n.'][rows][#rows#][columns][#columns#][width]']
							],
						],
						[
							'width' => 'three wide', 
							'params' => [
								'placeholder' => rl3('Class'), 
								'origin' => ['name' => 'Connection[views]['.$n.'][rows][#rows#][columns][#columns#][class]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'select',
							'options' =>  [
								'' => rl3('Left'),
								'right' => rl3('Right'),
								'center' => rl3('Center'),
							],
							'desc' => rl3('Text align'),
							'params' => [
								'placeholder' => '',
								'origin' => ['name' => 'Connection[views]['.$n.'][rows][#rows#][columns][#columns#][halign]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'select',
							'options' =>  [
								'' => rl3('No'),
								'right floated' => rl3('Right'),
								'left floated' => rl3('Left'),
							],
							'desc' => rl3('Floating'),
							'params' => [
								'placeholder' => '',
								'origin' => ['name' => 'Connection[views]['.$n.'][rows][#rows#][columns][#columns#][floating]']
							],
						],
						[
							'width' => 'three wide', 
							'type' => 'btns',
							'btns' => [
								'add' => ['text' => rl3('Column'), 'icon' => 'copy', 'color' => 'blue'],
								'delete' => ['hidden' => 1],
								'sort' => [],
							]
						],
					],
				],
			],
		]
	]);
?>