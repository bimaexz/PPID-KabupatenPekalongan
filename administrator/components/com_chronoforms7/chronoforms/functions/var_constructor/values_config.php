<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['values'],
		'items' => !empty($unit['values']) ? $unit['values'] : null,
		'btns' => ['values' => ['main' => ['text' => rl3('Set New Variable')]]],
		'inputs' => [
			'values' => [
				'main' => [
					'r1' => [
						[
							'width' => 'three wide', 
							'type' => 'select',
							'options' =>  [
								'var' => rl3('Variable'),
								'data' => rl3('Request Data'),
								'session' => rl3('Session Data'),
							],
							'params' => [
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][values][#values#][type]']
							],
						],
						[
							'width' => 'six wide', 
							'params' => [
								'placeholder' => rl3('Name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][values][#values#][name]']
							],
						],
						[
							'width' => 'six wide', 
							'params' => [
								'placeholder' => rl3('Value'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][values][#values#][value]']
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