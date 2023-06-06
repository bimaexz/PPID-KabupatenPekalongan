<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['pairs'],
		'items' => !empty($item['pairs']) ? $item['pairs'] : null,
		// 'btns' => ['pairs' => ['main' => ['text' => rl3('Add New Item Key/Value Pair'), 'color' => 'green']]],
		// 'visible' => ['pairs' => 1],
		'parents' => !empty($parents) ? $parents : [],
		'inputs' => [
			'pairs' => [
				'main' => [
					'r1' => [
						[
							'width' => 'twelve wide items_pairs_values items_pairs_short_text',
							'params' => [
								'placeholder' => rl3('New Value'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][items][#items#][pairs][#pairs#][value]']
							],
						],
						[
							'width' => 'three wide', 
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