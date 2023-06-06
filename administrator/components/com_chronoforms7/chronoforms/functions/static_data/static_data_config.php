<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['items'],
		'items' => !empty($unit['items']) ? $unit['items'] : null,
		'btns' => ['items' => ['main' => ['text' => rl3('Add New Source item')]]],
		'divider' => true,
		'inputs' => [
			'items' => [
				'main' => [
					'r1' => [
						[
							'width' => 'two wide ui button compact basic center black aligned', 
							'type' => 'string',
							'string' => rl3('Item key'),
						],
						[
							'width' => 'eight wide', 
							'type' => 'text',
							'params' => [
								'placeholder' => rl3('Item key'),
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][items][#items#][key]', 'value' => '#items#']
							],
							
						],
						[
							'width' => 'two wide', 
							'type' => 'btns',
							'btns' => [
								'add' => [],
								'delete' => [],
								'sort' => [],
							]
						],
						[
							'width' => 'three wide', 
							'type' => 'add_clone',
							'subgroup' => 'pairs',
							'icon' => 'edit',
							'text' => rl3('Add Data Pair'),
							'color' => 'green',
							'params' => [
								'data-hint' => rl3('Insert new Key/Value data pair in the current item'),
							],
						],
					],
					'pairs' => [
						[
							'type' => 'require',
							'file' => dirname(__FILE__).DS.'values_config.php',
							'vars' => ['n' => $n, 'utype' => $utype],
						],
					],
				],
			],
		]
	]);
?>