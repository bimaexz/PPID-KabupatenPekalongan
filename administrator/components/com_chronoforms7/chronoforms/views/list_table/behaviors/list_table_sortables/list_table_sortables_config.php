<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['sortables'],
		'items' => $unit['sortables'] ?? [],
		'btns' => ['sortables' => ['main' => ['text' => rl3('Add Sortable Field')]]],
		// 'visible' => ['sortables' => 1],
		'inputs' => [
			'sortables' => [
				'main' => [
					'r1' => [
						[
							'width' => 'ten wide', 
							'params' => [
								'placeholder' => rl3('Model Field Name'), 
								'origin' => ['name' => 'Connection[views]['.$n.'][sortables][#sortables#]']
							],
						],
						[
							'width' => 'three wide', 
							'type' => 'btns',
							'btns' => [
								'add' => [],
								'delete' => [],
							]
						],
					],
				],
			],
		]
	]);
?>