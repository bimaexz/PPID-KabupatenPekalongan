<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['rows'],
		'items' => !empty($unit['rows']) ? $unit['rows'] : null,
		'btns' => ['rows' => ['main' => ['text' => rl3('Add New Row')]]],
		'visible' => ['rows' => 1],
		'inputs' => [
			'rows' => [
				'main' => [
					'r1' => [
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
							],
							'desc' => rl3('Column count'),
							'params' => [
								'placeholder' => '',
								'origin' => ['name' => 'Connection[views]['.$n.'][rows][#rows#][column_count]']
							],
						],
						[
							'width' => 'three wide', 
							'params' => [
								'placeholder' => rl3('Class'), 
								'origin' => ['name' => 'Connection[views]['.$n.'][rows][#rows#][class]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'select',
							'options' =>  [
								'top' => rl3('Top'),
								'middle' => rl3('Middle'),
								'bottom' => rl3('Bottom'),
							],
							'desc' => rl3('Vertical align'),
							'params' => [
								'origin' => ['name' => 'Connection[views]['.$n.'][rows][#rows#][valign]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'select',
							'options' =>  [
								'' => rl3('No'),
								'centered' => rl3('Yes'),
							],
							'desc' => rl3('Centered'),
							'params' => [
								'placeholder' => '',
								'origin' => ['name' => 'Connection[views]['.$n.'][rows][#rows#][centered]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'select',
							'options' =>  [
								'' => rl3('No'),
								'stretched' => rl3('Yes'),
							],
							'desc' => rl3('Stretched'),
							'params' => [
								'placeholder' => '',
								'origin' => ['name' => 'Connection[views]['.$n.'][rows][#rows#][stretched]']
							],
						],
						[
							'width' => 'three wide', 
							'type' => 'btns',
							'btns' => [
								'add' => ['text' => rl3('Row')],
								'delete' => ['hidden' => 1],
								'sort' => [],
							]
						],
					],
					'r2' => [
						[
							'type' => 'require',
							'file' => dirname(__FILE__).DS.'columns_config.php',
							'vars' => ['unit' => $unit, 'n' => $n],
						],
					],
				],
			],
		]
	]);
?>