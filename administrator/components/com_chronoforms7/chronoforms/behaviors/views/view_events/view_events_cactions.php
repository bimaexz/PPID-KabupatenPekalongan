<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$options_settings =  [
		'fn' => json_encode(['hide' => ['.caction_param'], 'show' => ['.caction_p1']]),
		'value' => json_encode(['hide' => ['.caction_param'], 'show' => ['.caction_p1']]),
		'mvalue' => json_encode(['hide' => ['.caction_param'], 'show' => ['.caction_p1m']]),
		'submit_form' => json_encode(['hide' => ['.caction_param']]),
		'trigger' => json_encode(['hide' => ['.caction_param'], 'show' => ['.caction_p1']]),
		'trigger_after' => json_encode(['hide' => ['.caction_param'], 'show' => ['.caction_p1', '.caction_p2']]),
	];
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['cactions'],
		'items' => !empty($item['cactions']) ? $item['cactions'] : null,
		'parents' => !empty($parents) ? $parents : [],
		'inputs' => [
			'cactions' => [
				'main' => [
					'r1' => [
						[
							'width' => 'five wide', 
							'type' => 'select',
							'options' =>  [
								'value' => rl3('Set Value'),
								'mvalue' => rl3('Set Multi Value'),
								'fn' => rl3('Call Function'),
								'submit_form' => rl3('Submit Form'),
								'trigger' => rl3('Trigger'),
								'trigger_after' => rl3('Trigger After X microseconds'),
							],
							'options_settings' =>  $options_settings,
							'params' => [
								'data-cfwizardjob' => 'content-switcher',
								'placeholder' => rl3('Actions applied to this unit'),
								'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][cactions][#cactions#][action]']
							],
						],
						[
							'width' => 'five wide caction_param caction_p1', 
							'type' => 'text',
							'params' => [
								'placeholder' => rl3('Action Parameter'),
								'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][cactions][#cactions#][p1]']
							],
						],
						[
							'width' => 'five wide caction_param caction_p2', 
							'type' => 'text',
							'params' => [
								'placeholder' => rl3('Action Parameter 2'),
								'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][cactions][#cactions#][p2]']
							],
						],
						[
							'width' => 'five wide caction_param caction_p1m', 
							'type' => 'select',
							'options' =>  [
								
							],
							'params' => [
								'multiple' => 'multiple',
								'placeholder' => rl3('Enter one or more comma separated values'),
								'data-allowadditions' => '1',
								'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][cactions][#cactions#][p1m][]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'btns',
							'btns' => [
								// 'add' => [],
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