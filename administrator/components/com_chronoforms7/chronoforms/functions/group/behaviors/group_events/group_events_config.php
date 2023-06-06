<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['switch_events'],
		'items' => !empty($unit['switch_events']) ? $unit['switch_events'] : null,
		'btns' => ['switch_events' => ['main' => ['text' => rl3('Add New Event')]]],
		'inputs' => [
			'switch_events' => [
				'main' => [
					'r1' => [
						[
							'width' => 'six wide', 
							'params' => [
								'placeholder' => rl3('Event name'), 
								// 'readonly' => 'readonly',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][areas][#switch_events#][name]', 'value' => 'Event_#switch_events#']
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
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][switch_events][#switch_events#][logic]']
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

<?php $this->view($this->get('cf.paths.shared').'refresh_button.php'); ?>