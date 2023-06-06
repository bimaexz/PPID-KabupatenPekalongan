<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['conditions'],
		'items' => $items,
		'btns' => ['conditions' => ['main' => ['text' => rl3('Add Condition')]]],
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
								'placeholder' => '',
								'origin' => ['name' => $name.'[conditions][#conditions#][start]']
							],
						],
						[
							'width' => 'four wide',
							'params' => [
								'placeholder' => rl3('Table field name'), 
								'origin' => ['name' => $name.'[conditions][#conditions#][field]']
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
								'origin' => ['name' => $name.'[conditions][#conditions#][op]']
							],
						],
						[
							'width' => 'four wide',
							'params' => [
								'placeholder' => rl3('Value'), 
								'origin' => ['name' => $name.'[conditions][#conditions#][value]']
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
								'placeholder' => '',
								'origin' => ['name' => $name.'[conditions][#conditions#][end]']
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
								'placeholder' => '',
								'origin' => ['name' => $name.'[conditions][#conditions#][logic]']
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