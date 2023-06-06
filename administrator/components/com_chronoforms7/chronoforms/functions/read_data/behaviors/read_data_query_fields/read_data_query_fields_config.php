<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['fields'],
		'items' => $unit['models']['data']['fields'] ?? [],
		'btns' => ['fields' => ['main' => ['text' => rl3('Add Query Field')]]],
		'headers' => [
			'fields' => [
				['width' => 'ten wide', 'label' => rl3('New field')],
				['width' => 'four wide', 'label' => rl3('Field Alias')],
				['width' => 'two wide', 'label' => ''],
			],
		],
		'inputs' => [
			'fields' => [
				'main' => [
					'r1' => [
						[
							'width' => 'ten wide',
							'params' => [
								'placeholder' => rl3('Field name or function'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][fields][#fields#][field]']
							],
						],
						[
							'width' => 'four wide', 
							'params' => [
								'placeholder' => rl3('Field Alias including the Model name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][fields][#fields#][alias]']
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