<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$options_settings =  [
		'=' => json_encode(['hide' => ['.condition_value'], 'show' => ['.condition_svalue']]),
		'!=' => json_encode(['hide' => ['.condition_value'], 'show' => ['.condition_svalue']]),
		'>' => json_encode(['hide' => ['.condition_value'], 'show' => ['.condition_svalue']]),
		'>=' => json_encode(['hide' => ['.condition_value'], 'show' => ['.condition_svalue']]),
		'<' => json_encode(['hide' => ['.condition_value'], 'show' => ['.condition_svalue']]),
		'<=' => json_encode(['hide' => ['.condition_value'], 'show' => ['.condition_svalue']]),
		'LIKE' => json_encode(['hide' => ['.condition_value'], 'show' => ['.condition_svalue']]),
		'IN' => json_encode(['hide' => ['.condition_value'], 'show' => ['.condition_mvalue']]),
		'NOT' => json_encode(['hide' => ['.condition_value'], 'show' => ['.condition_mvalue']]),
		'IS' => json_encode(['hide' => ['.condition_value'], 'show' => ['.condition_svalue']]),
		'IS NOT' => json_encode(['hide' => ['.condition_value'], 'show' => ['.condition_svalue']]),
	];
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['conditions'],
		'items' => $unit['models']['data']['conditions'] ?? [],
		'btns' => ['conditions' => ['main' => ['text' => rl3('Add Where Condition'), 'color' => 'blue']]],
		
		'inputs' => [
			'conditions' => [
				'main' => [
					'r1' => [
						[
							'width' => 'one wide', 
							'type' => 'select',
							'options' =>  [
								'' => '',
								'(' => '(',
							],
							'params' => [
								'placeholder' => 'false',
								'data-dicon' => '',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][conditions][#conditions#][start]']
							],
						],
						[
							'width' => 'four wide',
							'params' => [
								'placeholder' => rl3('Table field name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][conditions][#conditions#][field]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'select',
							'options' =>  [
								'=' => '=',
								'!=' => '!=',
								'>' => '>',
								'>=' => '>=',
								'<' => '<',
								'<=' => '<=',
								'LIKE' => 'LIKE',
								'NOT LIKE' => 'NOT LIKE',
								'REGEXP' => 'REGEXP',
								'IN' => 'IN',
								'NOT' => 'NOT IN',
								'IS' => 'IS',
								'IS NOT' => 'IS NOT',
							],
							'options_settings' =>  $options_settings,
							'params' => [
								'data-cfwizardjob' => 'content-switcher',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][conditions][#conditions#][op]']
							],
						],
						[
							'width' => 'four wide condition_value condition_svalue',
							'params' => [
								'placeholder' => rl3('Value'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][conditions][#conditions#][value]']
							],
						],
						[
							'width' => 'four wide condition_value condition_mvalue',
							'type' => 'select',
							'options' =>  [
								
							],
							'params' => [
								'multiple' => 'multiple',
								'placeholder' => rl3('Enter one or more comma separated values'),
								'data-allowadditions' => '1',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][conditions][#conditions#][value][]']
							],
						],
						[
							'width' => 'one wide', 
							'type' => 'select',
							'options' =>  [
								'' => '',
								')' => ')',
							],
							'params' => [
								'placeholder' => 'false',
								'data-dicon' => '',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][conditions][#conditions#][end]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'select',
							'options' =>  [
								'' => '',
								'AND' => 'AND',
								'OR' => 'OR',
							],
							'params' => [
								'placeholder' => 'false',
								'data-dicon' => '',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][conditions][#conditions#][logic]']
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