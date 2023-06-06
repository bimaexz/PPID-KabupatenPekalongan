<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['columns'],
		'items' => !empty($unit['columns']) ? $unit['columns'] : null,
		'btns' => ['columns' => ['main' => ['text' => rl3('Add New Column')]]],
		'inputs' => [
			'columns' => [
				'main' => [
					'r1' => [
						[
							'width' => 'seven wide', 
							'params' => [
								'placeholder' => rl3('Field Data Path in the Data Provider'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][columns][#columns#][path]']
							],
						],
						[
							'width' => 'seven wide', 
							'params' => [
								'placeholder' => rl3('Optional Column Title'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][columns][#columns#][title]']
							],
						],
						[
							'width' => 'two wide', 
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