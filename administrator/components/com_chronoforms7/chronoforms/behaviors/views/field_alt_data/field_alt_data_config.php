<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['altdata'],
		'items' => !empty($unit['altdata']) ? $unit['altdata'] : null,
		'btns' => ['altdata' => ['main' => ['text' => rl3('Add New Alt Data Set')]]],
		'divider' => true,
		'inputs' => [
			'altdata' => [
				'main' => [
					'r1' => [
						// [
						// 	'width' => 'two wide ui button compact basic center black aligned', 
						// 	'type' => 'string',
						// 	'string' => rl3('Scope'),
						// ],
						[
							'width' => 'twelve wide', 
							'type' => 'select',
							'label' => rl3('Data Scope'),
							'options' =>  [
								'_data_' => rl3('Override Data'),
								'_action_email_content' => rl3('Email Content'),
								'_action_email_params' => rl3('Email Settings'),
								'_action_db_log' => rl3('DB Log'),
							],
							'params' => [
								'multiple' => 'multiple',
								'data-allowadditions' => 1,
								'data-clearable' => 1,
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][altdata][#altdata#][types][]']
							],
							'desc' => rl3('Select actions or enter a data variable postfix')
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
					'r2' => [
						[
							'type' => 'require',
							'file' => dirname(__FILE__).DS.'values_config.php',
							'vars' => ['n' => $n, 'utype' => $utype],
						],
					],
				],
			],
		]
	]);
?>