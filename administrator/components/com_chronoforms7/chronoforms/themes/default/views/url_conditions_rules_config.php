<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$options_settings =  [
		'fn' => json_encode(['hide' => ['.condition_params'], 'show' => ['.condition_p1']]),
		'value' => json_encode(['hide' => ['.caction_param'], 'show' => ['.caction_p1']]),
		'mvalue' => json_encode(['hide' => ['.caction_param'], 'show' => ['.caction_p1m']]),
		'submit_form' => json_encode(['hide' => ['.caction_param']]),
		'==' => json_encode(['hide' => ['.condition_params'], 'show' => ['.condition_p1']]),
		'!=' => json_encode(['hide' => ['.condition_params'], 'show' => ['.condition_p1']]),
		'>' => json_encode(['hide' => ['.condition_params'], 'show' => ['.condition_p1']]),
		'<' => json_encode(['hide' => ['.condition_params'], 'show' => ['.condition_p1']]),
		'>=' => json_encode(['hide' => ['.condition_params'], 'show' => ['.condition_p1']]),
		'<=' => json_encode(['hide' => ['.condition_params'], 'show' => ['.condition_p1']]),
		'regex' => json_encode(['hide' => ['.condition_params'], 'show' => ['.condition_p1']]),
		'!regex' => json_encode(['hide' => ['.condition_params'], 'show' => ['.condition_p1']]),
		'in' => json_encode(['hide' => ['.condition_params'], 'show' => ['.condition_p1m']]),
		'!in' => json_encode(['hide' => ['.condition_params'], 'show' => ['.condition_p1m']]),
		'empty' => json_encode(['hide' => ['.condition_params']]),
		'!empty' => json_encode(['hide' => ['.condition_params']]),
		'null' => json_encode(['hide' => ['.condition_params']]),
		'!null' => json_encode(['hide' => ['.condition_params']]),
		'numeric' => json_encode(['hide' => ['.condition_params']]),
		'bool' => json_encode(['hide' => ['.condition_params']]),
		'integer' => json_encode(['hide' => ['.condition_params']]),
		'string' => json_encode(['hide' => ['.condition_params']]),
	];
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['rules'],
		'items' => !empty($item['rules']) ? $item['rules'] : null,
		// 'btns' => ['email_conditions' => ['main' => ['text' => rl3('Add New Condition')]]],
		'visible' => ['rules' => 1],
		'parents' => !empty($parents) ? $parents : [],
		'inputs' => [
			'rules' => [
				'main' => [
					'r1' => [
						[
							'width' => 'six wide', 
							'params' => [
								'placeholder' => rl3('Request Param name'), 
								'origin' => ['name' => 'Extension[settings][system][url_conditions][#url_conditions#][rules][#rules#][first]']
							],
						],
						[
							'width' => 'three wide', 
							'type' => 'select',
							'options' =>  [
								'==' => rl3('=='),
								'!=' => rl3('!='),
								'>' => rl3('greater than'),
								'<' => rl3('less than'),
								'>=' => rl3('greater or equal'),
								'<=' => rl3('less or equal'),
								'regex' => rl3('matches'),
								'!regex' => rl3('NOT matches'),
								'in' => rl3('IN'),
								'!in' => rl3('NOT IN'),
								'empty' => rl3('is empty'),
								'!empty' => rl3('is not empty'),
								'null' => rl3('is NULL'),
								'!null' => rl3('is not NULL'),
								'numeric' => rl3('is numeric'),
								'bool' => rl3('is boolean'),
								'integer' => rl3('is integer'),
								'string' => rl3('is string'),
							],
							'options_settings' =>  $options_settings,
							'params' => [
								'data-cfwizardjob' => 'content-switcher',
								'origin' => ['name' => 'Extension[settings][system][url_conditions][#url_conditions#][rules][#rules#][sign]']
							],
						],
						[
							'width' => 'five wide condition_params condition_p1', 
							'params' => [
								'placeholder' => rl3('Request Param value'), 
								'origin' => ['name' => 'Extension[settings][system][url_conditions][#url_conditions#][rules][#rules#][second]']
							],
						],
						[
							'width' => 'five wide condition_params condition_p1m', 
							'type' => 'select',
							'options' =>  [
								
							],
							'params' => [
								'multiple' => 'multiple',
								'placeholder' => rl3('Comma separated values'),
								'data-allowadditions' => '1',
								'origin' => ['name' => 'Extension[settings][system][url_conditions][#url_conditions#][rules][#rules#][msecond][]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'btns',
							'btns' => [
								'add' => ['icon' => 'question', 'color' => 'green'],
								'delete' => ['hidden' => 1],
							]
						],
					],
				],
			],
		]
	]);
?>