<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Menu Items'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
			'groups' => ['items'],
			'items' => $unit['items'] ?? [],
			// 'btns' => ['items' => ['main' => ['text' => rl3('Add Table Column')]]],
			'visible' => ['items' => 1],
			'headers' => [
				'items' => [
					['width' => 'four wide', 'label' => rl3('name')],
					['width' => 'seven wide', 'label' => rl3('Header')],
					// ['width' => 'two wide', 'label' => rl3('Width')],
					['width' => 'three wide', 'label' => rl3('Class')],
					// ['width' => 'two wide', 'label' => 'Custom Header'],
					['width' => 'two wide', 'label' => ''],
				],
			],
			'inputs' => [
				'items' => [
					'main' => [
						'r1' => [
							[
								'width' => 'four wide', 
								'params' => [
									'placeholder' => rl3('ID'), 
									'origin' => ['name' => 'Connection[views]['.$n.'][areas][#items#][name]']
								],
							],
							[
								'width' => 'seven wide', 
								'params' => [
									'placeholder' => rl3('Title'), 
									'origin' => ['name' => 'Connection[views]['.$n.'][items][#items#][title]']
								],
							],
							// [
							// 	'width' => 'two wide', 
							// 	'type' => 'select',
							// 	'options' =>  [
							// 		'' => rl3('Auto'),
							// 		'collapsing' => rl3('Tight'),
							// 		'two wide' => '2/16',
							// 		'three wide' => '3/16',
							// 		'four wide' => '4/16',
							// 		'five wide' => '5/16',
							// 		'six wide' => '6/16',
							// 		'seven wide' => '7/16',
							// 		'eight wide' => '8/16',
							// 		'nine wide' => '9/16',
							// 		'ten wide' => '10/16',
							// 		'eleven wide' => '11/16',
							// 		'twelve wide' => '12/16',
							// 		'thrteen wide' => '13/16',
							// 		'fourteen wide' => '14/16',
							// 	],
							// 	'params' => [
							// 		'placeholder' => '',
							// 		'origin' => ['name' => 'Connection[views]['.$n.'][items][#items#][width]']
							// 	],
							// ],
							[
								'width' => 'three wide', 
								'params' => [
									'placeholder' => rl3('Class'), 
									'origin' => ['name' => 'Connection[views]['.$n.'][items][#items#][class]']
								],
							],
							// [
							// 	'width' => 'two wide center aligned', 
							// 	'type' => 'checkbox',
							// 	'params' => [
							// 		'value' => '{name} Header',
							// 		'origin' => ['name' => 'Connection[views]['.$n.'][areas][#items#][before][header]']
							// 	],
							// ],
							[
								'width' => 'two wide', 
								'type' => 'btns',
								'btns' => [
									'add' => [],
									'delete' => ['hidden' => 1],
									'sort' => [],
								]
							],
						],
					],
				],
			]
		]);
	?>
</div>

<?php $this->view($this->get('cf.paths.shared').'refresh_button.php'); ?>