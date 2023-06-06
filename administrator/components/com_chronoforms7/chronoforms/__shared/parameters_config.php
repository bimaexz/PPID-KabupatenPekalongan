<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(empty($name)){
		$name = 'parameters';
	}
	if(empty($text)){
		$text = rl3('Add Parameter');
	}
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => [$name],
		'items' => !empty($unit[$name]) ? $unit[$name] : null,
		'btns' => [$name => ['main' => ['text' => $text]]],
		'inputs' => [
			$name => [
				'main' => [
					'r1' => [
						[
							'width' => 'seven wide', 
							'params' => [
								'placeholder' => !empty($name_label) ? $name_label : rl3('Name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.']['.$name.'][#'.$name.'#][name]']
							],
						],
						[
							'width' => 'seven wide', 
							'params' => [
								'placeholder' => !empty($value_label) ? $value_label : rl3('Value'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.']['.$name.'][#'.$name.'#][value]']
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
				],
			],
		]
	]);
?>