<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['fields'],
		'items' => !empty($item['fields']) ? $item['fields'] : null,
		'btns' => ['fields' => ['main' => ['text' => rl3('Customize Table Field'), 'color' => 'green']]],
		'parents' => !empty($parents) ? $parents : [],
		'visible' => ['fields' => 1],
		'headers' => [
			'fields' => [
				['width' => 'four wide', 'label' => rl3('Field Name')],
				['width' => 'five wide', 'label' => rl3('Field Header')],
				['width' => 'five wide', 'label' => rl3('Display Type')],
				['width' => 'two wide', 'label' => ''],
			],
		],
		'inputs' => [
			'fields' => [
				'main' => [
					'r1' => [
						[
							'width' => 'four wide',
							'params' => [
								'placeholder' => rl3('Table field name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][connected_tables][db_tables][#db_tables#][fields][#fields#][name]']
							],
						],
						[
							'width' => 'five wide',
							'params' => [
								'placeholder' => rl3('Header Label'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][connected_tables][db_tables][#db_tables#][fields][#fields#][header]']
							],
						],
						[
							'width' => 'five wide', 
							'type' => 'select',
							'options' =>  [
								'text' => rl3('Text'),
								'longtext' => rl3('Multi Line Text'),
							],
							'params' => [
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][connected_tables][db_tables][#db_tables#][fields][#fields#][display_type]']
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