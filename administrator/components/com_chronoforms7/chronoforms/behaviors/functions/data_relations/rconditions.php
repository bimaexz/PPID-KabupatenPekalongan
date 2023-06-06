<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['rconditions'],
		'items' => !empty($item['rconditions']) ? $item['rconditions'] : [],
		//'btns' => ['rconditions' => ['main' => ['text' => rl3('Add Order Field'), 'color' => 'green']]],
		'parents' => !empty($parents) ? $parents : [],
		'visible' => ['rconditions' => 1],
		'inputs' => [
			'rconditions' => [
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
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][relations][#relations#][rconditions][#rconditions#][start]']
							],
						],
						[
							'width' => 'four wide',
							'params' => [
								'placeholder' => rl3('Table field name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][relations][#relations#][rconditions][#rconditions#][field]']
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
								'IN' => 'IN',
								'NOT' => 'NOT IN',
								'IS' => 'IS',
								'IS NOT' => 'IS NOT',
							],
							'params' => [
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][relations][#relations#][rconditions][#rconditions#][op]']
							],
						],
						[
							'width' => 'four wide',
							'params' => [
								'placeholder' => rl3('Value'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][relations][#relations#][rconditions][#rconditions#][value]']
							],
						],
						[
							'width' => 'one wide', 
							'type' => 'select',
							'options' =>  [
								'field' => 'Field',
								'value' => 'Value',
							],
							'params' => [
								'placeholder' => 'false',
								'data-dicon' => '',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][relations][#relations#][rconditions][#rconditions#][value_type]']
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
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][relations][#relations#][rconditions][#rconditions#][end]']
							],
						],
						[
							'width' => 'one wide', 
							'type' => 'select',
							'options' =>  [
								'' => '',
								'AND' => 'AND',
								'OR' => 'OR',
							],
							'params' => [
								'placeholder' => 'false',
								'data-dicon' => '',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][relations][#relations#][rconditions][#rconditions#][logic]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'btns',
							'btns' => [
								'add' => ['color' => 'green'],
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