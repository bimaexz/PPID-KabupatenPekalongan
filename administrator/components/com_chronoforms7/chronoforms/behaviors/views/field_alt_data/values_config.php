<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$options_settings =  [
		'==' => json_encode(['hide' => ['.altdata_values'], 'show' => ['.altdata_values_single']]),
		'!=' => json_encode(['hide' => ['.altdata_values'], 'show' => ['.altdata_values_single']]),
		'regex' => json_encode(['hide' => ['.altdata_values'], 'show' => ['.altdata_values_single']]),
		'>' => json_encode(['hide' => ['.altdata_values'], 'show' => ['.altdata_values_single']]),
		'>=' => json_encode(['hide' => ['.altdata_values'], 'show' => ['.altdata_values_single']]),
		'<' => json_encode(['hide' => ['.altdata_values'], 'show' => ['.altdata_values_single']]),
		'<=' => json_encode(['hide' => ['.altdata_values'], 'show' => ['.altdata_values_single']]),
		'in' => json_encode(['hide' => ['.altdata_values'], 'show' => ['.altdata_values_multi']]),
		'!in' => json_encode(['hide' => ['.altdata_values'], 'show' => ['.altdata_values_multi']]),
		'any' => json_encode(['hide' => ['.altdata_values'], 'show' => ['.altdata_values_empty']]),
	];
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['values'],
		'items' => !empty($item['values']) ? $item['values'] : null,
		'btns' => ['values' => ['main' => ['text' => rl3('Add New Value'), 'color' => 'green']]],
		'visible' => ['values' => 1],
		'parents' => !empty($parents) ? $parents : [],
		'headers' => [
			'values' => [
				['width' => 'two wide', 'label' => rl3('Rule')],
				['width' => 'five wide', 'label' => rl3('Field Value')],
				['width' => 'seven wide', 'label' => rl3('New Value')],
				['width' => 'two wide', 'label' => ''],
			],
		],
		'inputs' => [
			'values' => [
				'main' => [
					'r1' => [
						[
							'width' => 'two wide',
							'type' => 'select',
							'options' =>  [
								'==' => '=',
								'!=' => '!=',
								'>' => '>',
								'>=' => '>=',
								'<' => '<',
								'<=' => '<=',
								'regex' => rl3('Matches'),
								'in' => rl3('IN'),
								'!in' => rl3('NOT IN'),
								'any' => rl3('Any'),
							],
							'options_settings' =>  $options_settings,
							'params' => [
								'data-cfwizardjob' => 'content-switcher',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][altdata][#altdata#][values][#values#][rule]']
							],
						],
						[
							'width' => 'five wide altdata_values altdata_values_single',
							'params' => [
								'placeholder' => rl3('Option Value'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][altdata][#altdata#][values][#values#][value]']
							],
						],
						[
							'width' => 'five wide altdata_values altdata_values_multi',
							'type' => 'select',
							'params' => [
								'placeholder' => rl3('Enter values separated by comma'),
								'multiple' => 'multiple',
								'data-allowadditions' => 1,
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][altdata][#altdata#][values][#values#][mvalue][]']
							],
						],
						[
							'width' => 'five wide field aligned altdata_values altdata_values_empty', 
							'type' => 'string',
							'string' => '',
						],
						[
							'width' => 'seven wide',
							'params' => [
								'placeholder' => rl3('New Option Value'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][altdata][#altdata#][values][#values#][svalue]']
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