<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$options_settings =  [
		'short_text' => json_encode(['hide' => ['.products_pairs_values'], 'show' => ['.products_pairs_short_text']]),
		'long_text' => json_encode(['hide' => ['.products_pairs_values'], 'show' => ['.products_pairs_long_text']]),
		'array' => json_encode(['hide' => ['.products_pairs_values'], 'show' => ['.products_pairs_array']]),
	];
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['pairs'],
		'items' => !empty($item['pairs']) ? $item['pairs'] : null,
		'btns' => ['pairs' => ['main' => ['text' => rl3('Add More Product Data'), 'color' => 'green']]],
		// 'visible' => ['pairs' => 1],
		'parents' => !empty($parents) ? $parents : [],

		'inputs' => [
			'pairs' => [
				'main' => [
					'r1' => [
						[
							'width' => 'five wide',
							'params' => [
								'placeholder' => rl3('Data Key'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][products][#products#][pairs][#pairs#][key]']
							],
						],
						[
							'width' => 'two wide',
							'type' => 'select',
							'options' =>  [
								'short_text' => rl3('Short Text'),
								'long_text' => rl3('Long Text'),
								'array' => rl3('Array'),
							],
							'options_settings' =>  $options_settings,
							'params' => [
								'data-cfwizardjob' => 'content-switcher',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][products][#products#][pairs][#pairs#][type]']
							],
						],
						[
							'width' => 'six wide products_pairs_values products_pairs_short_text',
							'params' => [
								'placeholder' => rl3('Data Value'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][products][#products#][pairs][#pairs#][short_text]']
							],
						],
						[
							'width' => 'six wide products_pairs_values products_pairs_long_text',
							'type' => 'textarea',
							'params' => [
								'placeholder' => rl3('Data Value'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][products][#products#][pairs][#pairs#][long_text]']
							],
						],
						[
							'width' => 'six wide products_pairs_values products_pairs_array',
							'type' => 'select',
							'params' => [
								'placeholder' => rl3('Enter values separated by comma'),
								'multiple' => 'multiple',
								'data-allowadditions' => 1,
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][products][#products#][pairs][#pairs#][array][]']
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