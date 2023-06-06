<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$actions = [
		'toggle_show' => rl3('Toggle Shown'),
		'show' => rl3('Show'),
		'hide' => rl3('Hide'),
		'toggle_enable' => rl3('Toggle Field(s) Enabled'),
		'enable' => rl3('Enable Field(s)'),
		'disable' => rl3('Disable Field(s)'),
		'toggle_validation' => rl3('Toggle Field(s) Validation Enabled'),
		'enable_validation' => rl3('Enable Field(s) Validation'),
		'disable_validation' => rl3('Disable Field(s) Validation'),
		'clear' => rl3('Clear Field(s)'),
		'remove' => rl3('Remove'),
		'reload' => rl3('Reload'),
		'ajax' => rl3('AJAX'),
	];

	if($unit['type'] == 'field_checkboxes'){
		$actions['checkAll'] = rl3('Check All');
		$actions['uncheckAll'] = rl3('UnCheck All');
	}
	if($unit['type'] == 'area_modal'){
		$actions['showModal'] = rl3('Show Modal');
		$actions['hideModal'] = rl3('Hide Modal');
	}
	if($unit['type'] == 'area_popup'){
		$actions['showPopup'] = rl3('Show Popup');
		$actions['hidePopup'] = rl3('Hide Popup');
	}
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['vevents'],
		'items' => !empty($unit['vevents']) ? $unit['vevents'] : null,
		'btns' => ['vevents' => ['main' => ['text' => rl3('Add New Event')]]],
		'divider' => true,
		'inputs' => [
			'vevents' => [
				'main' => [
					'r1' => [
						[
							'width' => 'nine wide', 
							'type' => 'select',
							'options' =>  $actions,
							'params' => [
								'multiple' => 'multiple',
								'placeholder' => rl3('Actions applied to this unit'),
								'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][actions][]']
							],
						],
						[
							'width' => 'one wide', 
							'type' => 'add_clone',
							'subgroup' => 'cactions',
							'icon' => 'edit',
							'text' => '',
							'color' => '',
							'params' => [
								'data-hint' => rl3('Add Complex Action'),
							],
						],
						[
							'width' => 'four wide', 
							'type' => 'select',
							'options' =>  [
								'or' => rl3('if ANY match'),
								'and' => rl3('if ALL match'),
							],
							'params' => [
								'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][logic]']
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
					'cactions' => [
						[
							'type' => 'require',
							'file' => dirname(__FILE__).DS.'view_events_cactions.php',
							'vars' => ['n' => $n],
						],
					],
					'r2' => [
						[
							'type' => 'require',
							'file' => dirname(__FILE__).DS.'view_events_rules.php',
							'vars' => ['n' => $n],
						],
					],
				],
			],
		]
	]);
?>