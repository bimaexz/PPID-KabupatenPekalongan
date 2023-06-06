<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['icon_options'],
		'items' => !empty($unit['icon_options']) ? $unit['icon_options'] : null,
		//'visible' => ['icon_options' => 1],
		'btns' => ['icon_options' => ['main' => ['text' => rl3('Add Icon Option')]]],
		'headers' => [
			'icon_options' => [
				['width' => 'seven wide', 'label' => rl3('Value')],
				['width' => 'seven wide', 'label' => rl3('Icon')],
				// ['width' => 'four wide', 'label' => rl3('Type')],
				['width' => 'two wide', 'label' => ''],
			],
		],
		'inputs' => [
			'icon_options' => [
				'main' => [
					'r1' => [
						[
							'width' => 'seven wide',
							'params' => [
								'placeholder' => rl3('Option Value'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][icon_options][#icon_options#][value]']
							],
						],
						[
							'width' => 'seven wide',
							'type' => 'input',
							'params' => [
								'placeholder' => rl3('Icon class'), 
								'data-iconpreview' => 1,
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][icon_options][#icon_options#][data-icon]']
							],
						],
						// [
						// 	'width' => 'four wide', 
						// 	'type' => 'select',
						// 	'options' =>  [
						// 		'item' => rl3('Item'),
						// 		'header' => rl3('Header'),
						// 	],
						// 	'params' => [
						// 		'origin' => ['name' => 'Connection['.$utype.']['.$n.'][icon_options][#icon_options#][data-type]']
						// 	],
						// ],
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