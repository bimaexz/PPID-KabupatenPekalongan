<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['fields'],
		'items' => !empty($item['fields']) ? $item['fields'] : null,
		'btns' => ['fields' => ['main' => ['text' => rl3('Add Table Field'), 'color' => 'green']]],
		'parents' => !empty($parents) ? $parents : [],
		'visible' => ['fields' => 1],
		'headers' => [
			'fields' => [
				['width' => 'four wide', 'label' => rl3('Name')],
				['width' => 'two wide', 'label' => rl3('Type')],
				['width' => 'one wide', 'label' => rl3('Length')],
				['width' => 'three wide', 'label' => rl3('Default')],
				['width' => 'one wide', 'label' => rl3('Null')],
				['width' => 'two wide', 'label' => rl3('Index')],
				['width' => 'one wide', 'label' => rl3('Auto')],
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
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][installer][db_tables][#db_tables#][fields][#fields#][name]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'select',
							'options' =>  [
								'INT' => rl3('INT'),
								'TINYINT' => rl3('TINYINT'),
								'VARCHAR' => rl3('VARCHAR'),
								'TEXT' => rl3('TEXT'),
								'LONGTEXT' => rl3('LONGTEXT'),
								'DATE' => rl3('DATE'),
								'DATETIME' => rl3('DATETIME'),
							],
							'params' => [
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][installer][db_tables][#db_tables#][fields][#fields#][type]']
							],
						],
						[
							'width' => 'one wide',
							'params' => [
								'placeholder' => rl3('Length'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][installer][db_tables][#db_tables#][fields][#fields#][length]']
							],
						],
						[
							'width' => 'three wide', 
							'type' => 'select',
							'options' =>  [
								'' => rl3('None'),
								'NULL' => rl3('NULL'),
							],
							'params' => [
								'data-allowadditions' => 1,
								'placeholder' => '',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][installer][db_tables][#db_tables#][fields][#fields#][default]']
							],
						],
						[
							'width' => 'one wide', 
							'type' => 'select',
							'options' =>  [
								'' => rl3('No'),
								'1' => rl3('YES'),
							],
							'params' => [
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][installer][db_tables][#db_tables#][fields][#fields#][null]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'select',
							'options' =>  [
								'' => '',
								'PRIMARY KEY' => rl3('PRIMARY'),
								'UNIQUE' => rl3('UNIQUE'),
								'INDEX' => rl3('INDEX'),
								'FULLTEXT' => rl3('FULLTEXT'),
							],
							'params' => [
								'placeholder' => '',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][installer][db_tables][#db_tables#][fields][#fields#][key]']
							],
						],
						[
							'width' => 'one wide', 
							'type' => 'select',
							'options' =>  [
								'' => rl3('No'),
								'1' => rl3('YES'),
							],
							'params' => [
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][installer][db_tables][#db_tables#][fields][#fields#][AI]']
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