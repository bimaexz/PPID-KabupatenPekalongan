<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['order'],
		'items' => $unit['models']['data']['order'] ?? [],
		'btns' => ['order' => ['main' => ['text' => rl3('Add Order Field')]]],
		'headers' => [
			'order' => [
				['width' => 'eight wide', 'label' => rl3('Table field')],
				['width' => 'six wide', 'label' => rl3('Direction')],
				['width' => 'two wide', 'label' => ''],
			],
		],
		'inputs' => [
			'order' => [
				'main' => [
					'r1' => [
						[
							'width' => 'eight wide',
							'params' => [
								'placeholder' => rl3('Table field name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][order][#order#][field]']
							],
						],
						[
							'width' => 'six wide', 
							'type' => 'select',
							'options' =>  [
								'ASC' => rl3('Ascending'),
								'DESC' => rl3('Descending'),
								'RAND' => rl3('Random'),
							],
							'params' => [
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][order][#order#][direction]']
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