<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Options'); ?></label>
	<?php
		if($unit['type'] == 'field_select'){
			$selected = 'selected';
			$ignore_type = false;
		}else{
			$selected = 'checked';
			$ignore_type = true;
		}
	?>
	<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
			'groups' => ['options'],
			'items' => isset($unit['_parent']) ? ($unit['options'] ?? []) : [
				1 => ['value' => '1', 'content' => 'Option 1'],
				2 => ['value' => '2', 'content' => 'Option 2'],
				3 => ['value' => '3', 'content' => 'Option 3'],
			],
			'btns' => ['options' => ['main' => ['text' => rl3('Add New Option')]]],
			'visible' => ['options' => (!empty($unit['uid']) ? 0 : 1)],
			'headers' => [
				'options' => [
					['width' => 'six wide', 'label' => rl3('Value')],
					['width' => 'six wide', 'label' => rl3('Text (Optional)')],
					['width' => 'two wide', 'label' => rl3('Selected')],
					['width' => 'two wide', 'label' => ''],
				],
			],
			'inputs' => [
				'options' => [
					'main' => [
						'r1' => [
							[
								'width' => 'six wide',
								'params' => [
									'placeholder' => rl3('Option Value'), 
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][options][#options#][value]', 'value' => '#options#']
								],
							],
							[
								'width' => 'six wide',
								'params' => [
									'placeholder' => rl3('Option Text'), 
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][options][#options#][content]', 'value' => 'Option #options#']
								],
							],
							[
								'width' => 'two wide center aligned', 
								'type' => 'checkbox',
								'params' => [
									'value' => $selected,
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][options][#options#]['.$selected.']']
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
						// 'r2_options' => [
						// 	[
						// 		'width' => 'four wide',
						// 		'params' => [
						// 			'placeholder' => rl3('Option Value'), 
						// 			'origin' => ['name' => 'Connection['.$utype.']['.$n.'][options][#options#][value]', 'value' => '#options#']
						// 		],
						// 	],
						// 	[
						// 		'width' => 'six wide',
						// 		'params' => [
						// 			'placeholder' => rl3('Option Text'), 
						// 			'origin' => ['name' => 'Connection['.$utype.']['.$n.'][options][#options#][content]', 'value' => 'Option #options#']
						// 		],
						// 	],
						// 	[
						// 		'width' => 'three wide', 
						// 		'type' => 'select',
						// 		'ignore' => $ignore_type,
						// 		'options' =>  [
						// 			'item' => rl3('Item'),
						// 			'header' => rl3('Header'),
						// 			//'divider' => rl3('Divider'),
						// 		],
						// 		'params' => [
						// 			'origin' => ['name' => 'Connection['.$utype.']['.$n.'][options][#options#][data-type]']
						// 		],
						// 	],
						// 	[
						// 		'width' => 'three wide', 
						// 		'type' => 'empty',
						// 	],
						// ],
					],
				],
			]
		]);
	?>
</div>