<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['header_options'],
		'items' => !empty($unit['header_options']) ? $unit['header_options'] : null,
		//'visible' => ['header_options' => 1],
		'btns' => ['header_options' => ['main' => ['text' => rl3('Add Rich Option')]]],
		'headers' => [
			'header_options' => [
				['width' => 'seven wide', 'label' => rl3('Value')],
				// ['width' => 'five wide', 'label' => rl3('Icon')],
				['width' => 'seven wide', 'label' => rl3('Type')],
				['width' => 'two wide', 'label' => ''],
			],
		],
		'inputs' => [
			'header_options' => [
				'main' => [
					'r1' => [
						[
							'width' => 'seven wide',
							'params' => [
								'placeholder' => rl3('Option Value'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][header_options][#header_options#][value]']
							],
						],
						// [
						// 	'width' => 'five wide',
						// 	'type' => 'input',
						// 	'params' => [
						// 		'placeholder' => rl3('Icon class'), 
						// 		'data-iconpreview' => 1,
						// 		'origin' => ['name' => 'Connection['.$utype.']['.$n.'][header_options][#header_options#][data-icon]']
						// 	],
						// ],
						[
							'width' => 'seven wide', 
							'type' => 'select',
							'options' =>  [
								'item' => rl3('Item'),
								'header' => rl3('Header'),
								'disabled' => rl3('Disabled'),
							],
							'params' => [
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][header_options][#header_options#][data-type]']
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