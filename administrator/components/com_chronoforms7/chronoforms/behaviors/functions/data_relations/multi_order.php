<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['multi_order'],
		'items' => !empty($item['multi_order']) ? $item['multi_order'] : null,
		'btns' => ['multi_order' => ['main' => ['text' => rl3('Add Order Field'), 'color' => 'green']]],
		'parents' => !empty($parents) ? $parents : [],
		//'visible' => ['multi_order' => 1],
		'inputs' => [
			'multi_order' => [
				'main' => [
					'r1' => [
						[
							'width' => 'eight wide',
							'params' => [
								'placeholder' => rl3('Table field name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][relations][#relations#][multi_order][#multi_order#][field]']
							],
						],
						[
							'width' => 'six wide', 
							'type' => 'select',
							'options' =>  [
								'ASC' => rl3('Ascending'),
								'DESC' => rl3('Descending'),
							],
							'params' => [
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][relations][#relations#][multi_order][#multi_order#][direction]']
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
					],
				],
			],
		]
	]);
?>