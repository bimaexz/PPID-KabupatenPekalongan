<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['relations'],
		'items' => $unit['models']['data']['relations'] ?? [],
		'btns' => ['relations' => ['main' => ['text' => rl3('Add New Model Relation')]]],
		'divider' => ['end' => []],
		'inputs' => [
			'relations' => [
				'main' => [
					'r1' => [
						[
							'width' => 'six wide',
							'params' => [
								'placeholder' => rl3('Related Model Name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][relations][#relations#][model]']
							],
						],
						[
							'width' => 'eight wide', 
							'type' => 'select',
							'options' =>  array_merge(['' => rl3('Database Table Name')], $this->controller->Models->tables()),
							'params' => [
								'data-clearable' => 1,
								'data-fulltextsearch' => 1,
								'data-keepnonexistent' => 1,
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][relations][#relations#][table]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'btns',
							'btns' => [
								//'add' => [],
								'delete' => [],
								'sort' => [],
							]
						],
					],
					'r2' => [
						[
							'width' => 'six wide',
							'params' => [
								'placeholder' => rl3('Related to'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][relations][#relations#][related_to]']
							],
						],
						[
							'width' => 'eight wide', 
							'type' => 'select',
							'options' =>  [
								'hasOne' => rl3('One matching record, foreign key in this model'),
								'hasMany' => rl3('Multiple matching records, foreign key in this model'),
								'belongsTo' => rl3('One matching record, foreign key in related model'),
								'subqueryJoin' => rl3('SubQuery Join, one matching record'),
							],
							'options_settings' =>  [
								'hasOne' => json_encode(['hide' => ['.multi_order_list']]),
								'hasMany' => json_encode(['show' => ['.multi_order_list']]),
								'belongsTo' => json_encode(['hide' => ['.multi_order_list']]),
								'subqueryJoin' => json_encode(['hide' => ['.multi_order_list']]),
							],
							'params' => [
								'data-cfwizardjob' => 'content-switcher',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][relations][#relations#][relation]']
							],
						],
					],
					'rconditions' => [
						[
							'type' => 'require',
							'file' => dirname(__FILE__).DS.'rconditions.php',
							'vars' => ['unit' => $unit, 'n' => $n, 'utype' => $utype],
						],
					],
					'multi_order_list' => [
						[
							'type' => 'require',
							'file' => dirname(__FILE__).DS.'multi_order.php',
							'vars' => ['unit' => $unit, 'n' => $n, 'utype' => $utype],
						],
					],
				],
			],
		]
	]);
?>