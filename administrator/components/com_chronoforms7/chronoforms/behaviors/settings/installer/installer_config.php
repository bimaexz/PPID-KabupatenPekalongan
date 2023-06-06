<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
			'groups' => ['db_tables'],
			'items' => $this->data('Connection.'.$utype.'.'.$n.'.installer.db_tables', []) ?? [],
			'btns' => ['db_tables' => ['main' => ['text' => rl3('Add DB Table')]]],
			'inputs' => [
				'db_tables' => [
					'main' => [
						'r1' => [
							[
								'width' => 'twelve wide', 
								'desc' => rl3('Table Name'), 
								'params' => [
									'placeholder' => rl3('Table Name'), 
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][installer][db_tables][#db_tables#][name]', 'value' => '#__custom_table_#db_tables#']
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
						'table_fields' => [
							[
								'type' => 'require',
								'file' => dirname(__FILE__).DS.'table_fields.php',
								'vars' => ['unit' => $unit, 'n' => $n, 'utype' => $utype],
							],
						],
					],
				],
			]
		]);
	?>