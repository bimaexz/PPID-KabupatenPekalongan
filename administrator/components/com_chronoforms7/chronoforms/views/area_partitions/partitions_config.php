<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['partitions'],
		'items' => !empty($unit['partitions']) ? $unit['partitions'] : [1 => [], 2 => []],
		'btns' => ['partitions' => ['main' => ['text' => rl3('Add New Partition')]]],
		'inputs' => [
			'partitions' => [
				'main' => [
					'r1' => [
						[
							'width' => 'six wide', 
							'params' => [
								'placeholder' => rl3('Partition Name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][areas][#partitions#][name]', 'value' => 'part#partitions#']
							],
						],
						[
							'width' => 'six wide', 
							'params' => [
								'placeholder' => rl3('Partition Label'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][areas][#partitions#][value]', 'value' => 'Area #partitions#']
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
