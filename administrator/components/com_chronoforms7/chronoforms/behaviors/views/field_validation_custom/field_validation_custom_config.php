<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['crules'],
		'items' => !empty($unit['fns']['validation']['fields'][$n]['crules']) ? $unit['fns']['validation']['fields'][$n]['crules'] : null,
		'btns' => ['crules' => ['main' => ['text' => rl3('Add Custom Rule')]]],
		'inputs' => [
			'crules' => [
				'main' => [
					'r1' => [
						[
							'width' => 'five wide', 
							'params' => [
								'placeholder' => rl3('Rule name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][fns][validation][fields]['.$n.'][crules][#crules#][name]']
							],
						],
						[
							'width' => 'nine wide', 
							'params' => [
								'placeholder' => rl3('Error message'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][fns][validation][fields]['.$n.'][crules][#crules#][error]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'btns',
							'btns' => [
								//'add' => [],
								'delete' => [],
							]
						],
					],
					'r2' => [
						[
							'width' => 'sixteen wide',
							'type' => 'textarea', 
							'desc' => rl3('JavaScript function to test the rule, function argument is the field value, return true or false'), 
							'params' => [
								'placeholder' => rl3('Rule JS definition'), 
								'rows' => 7,
								'data-codeeditor' => '{"mode":"js"}',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][fns][validation][fields]['.$n.'][crules][#crules#][jsdef]']
							],
						],
					],
					'r3' => [
						[
							'width' => 'sixteen wide',
							'type' => 'textarea', 
							'desc' => rl3('PHP code to test the rule, use $value for the field value, return true or false'), 
							'params' => [
								'placeholder' => rl3('Rule PHP definition'), 
								'rows' => 7,
								'data-codeeditor' => '{"mode":"php"}',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][fns][validation][fields]['.$n.'][crules][#crules#][phpdef]']
							],
						],
					],
				],
			],
		]
	]);
?>