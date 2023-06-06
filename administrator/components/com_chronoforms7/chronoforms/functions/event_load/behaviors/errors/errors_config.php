<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['errors'],
		'items' => !empty($unit['errors']) ? $unit['errors'] : null,
		'btns' => ['errors' => ['main' => ['text' => rl3('Add New Error')]]],
		'inputs' => [
			'errors' => [
				'main' => [
					'r1' => [
						[
							'width' => 'twelve wide', 
							'params' => [
								'placeholder' => rl3('Error text'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][errors][#errors#][text]']
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