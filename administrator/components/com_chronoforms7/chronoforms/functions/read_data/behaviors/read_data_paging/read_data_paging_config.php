<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['paging_reset'],
		'items' => $unit['models']['data']['paging_reset'] ?? [],
		'btns' => ['paging_reset' => ['main' => ['text' => rl3('Add Paging Reset Field')]]],
		'headers' => [
			'paging_reset' => [
				['width' => 'eight wide', 'label' => rl3('Reset field name')],
				['width' => 'two wide', 'label' => ''],
			],
		],
		'inputs' => [
			'paging_reset' => [
				'main' => [
					'r1' => [
						[
							'width' => 'eight wide',
							'params' => [
								'placeholder' => rl3('Field name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][paging_reset][#paging_reset#][field]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'btns',
							'btns' => [
								'add' => [],
								'delete' => [],
								// 'sort' => [],
							]
						],
					],
				],
			],
		]
	]);
?>