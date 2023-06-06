<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['fields'],
		'items' => !empty($unit['fields']) ? $unit['fields'] : null,
		'btns' => ['fields' => ['main' => ['text' => rl3('Add New Upload Field')]]],
		'inputs' => [
			'fields' => [
				'main' => [
					'r1' => [
						[
							'width' => 'five wide', 
							'params' => [
								'placeholder' => rl3('Field Name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][fields][#fields#][fieldname]']
							],
						],
						[
							'width' => 'five wide', 
							'params' => [
								'placeholder' => rl3('Optional Extensions List'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][fields][#fields#][extensions]']
							],
						],
						[
							'width' => 'three wide', 
							'params' => [
								'placeholder' => rl3('Max Size in KB'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][fields][#fields#][max_size]']
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