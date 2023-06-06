<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['conditions'],
		'items' => !empty($unit['conditions']) ? $unit['conditions'] : null,
		'btns' => ['conditions' => ['main' => ['text' => rl3('Add New Condition')]]],
		'inputs' => [
			'conditions' => [
				'main' => [
					'r1' => [
						[
							'width' => 'six wide', 
							'params' => [
								'placeholder' => rl3('Condition name'), 
								// 'readonly' => 'readonly',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][conditions][#conditions#][name]', 'value' => 'Condition #conditions#']
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
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][conditions][#conditions#][logic]']
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