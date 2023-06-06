<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['email_conditions'],
		'items' => !empty($unit['email_conditions']) ? $unit['email_conditions'] : null,
		'btns' => ['email_conditions' => ['main' => ['text' => rl3('Add New Email Condition')]]],
		'inputs' => [
			'email_conditions' => [
				'main' => [
					'r1' => [
						[
							'width' => 'six wide', 
							'params' => [
								'placeholder' => rl3('Condition name'), 
								// 'readonly' => 'readonly',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][email_conditions][#email_conditions#][name]', 'value' => 'Email Condition #email_conditions#']
							],
						],
						[
							'width' => 'eight wide', 
							'type' => 'select',
							'options' =>  [
								'and' => rl3('if ALL rules match'),
								'or' => rl3('if ANY rules match'),
							],
							'params' => [
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][email_conditions][#email_conditions#][logic]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'btns',
							'btns' => [
								'add' => [],
								'delete' => [],
							]
						],
					],
					'r2' => [
						[
							'type' => 'require',
							'file' => dirname(__FILE__).DS.'rules_config.php',
							'vars' => ['n' => $n, 'utype' => $utype],
						],
					],
				],
			],
		]
	]);
?>