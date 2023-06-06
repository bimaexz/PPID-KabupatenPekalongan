<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['group'],
		'items' => $unit['models']['data']['group'] ?? [],
		'btns' => ['group' => ['main' => ['text' => rl3('Add Group Field')]]],
		'inputs' => [
			'group' => [
				'main' => [
					'r1' => [
						[
							'width' => 'fourteen wide',
							'params' => [
								'placeholder' => rl3('Field name or function'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][group][#group#][field]']
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
				],
			],
		]
	]);
?>