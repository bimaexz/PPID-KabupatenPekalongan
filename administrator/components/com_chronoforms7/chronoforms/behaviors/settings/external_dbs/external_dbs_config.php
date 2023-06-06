<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['external_dbs'],
		'items' => $this->data('Connection.'.$utype.'.'.$n.'.external_dbs', []) ?? [],
		'btns' => ['external_dbs' => ['main' => ['text' => rl3('Add DB Connection')]]],
		'inputs' => [
			'external_dbs' => [
				'main' => [
					'r1' => [
						[
							'width' => 'eight wide', 
							'desc' => rl3('DB Connection title'), 
							'params' => [
								'placeholder' => rl3('DB Connection title'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][external_dbs][#external_dbs#][title]', 'value' => 'DB Connection #external_dbs#']
							],
						],
						[
							'width' => 'six wide', 
							'desc' => rl3('DB Connection id, used to reference this connection, do NOT change this after using the connection anywhere in the form'), 
							'params' => [
								'placeholder' => rl3('DB Connection id'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][external_dbs][#external_dbs#][alias]', 'value' => 'external_db_#external_dbs#']
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
							'width' => 'five wide', 
							'type' => 'text',
							'params' => [
								'placeholder' => rl3('DB Name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][external_dbs][#external_dbs#][name]']
							],
						],
						[
							'width' => 'five wide', 
							'type' => 'text',
							'params' => [
								'placeholder' => rl3('DB Username'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][external_dbs][#external_dbs#][user]']
							],
						],
						[
							'width' => 'five wide', 
							'type' => 'text',
							'params' => [
								'placeholder' => rl3('DB Userpass'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][external_dbs][#external_dbs#][pass]']
							],
						],
					],
					'r3' => [
						[
							'width' => 'five wide', 
							'type' => 'text',
							'params' => [
								'placeholder' => rl3('DB Host'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][external_dbs][#external_dbs#][host]']
							],
						],
						[
							'width' => 'five wide', 
							'type' => 'text',
							'params' => [
								'placeholder' => rl3('DB Type'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][external_dbs][#external_dbs#][type]']
							],
						],
						[
							'width' => 'five wide', 
							'type' => 'text',
							'params' => [
								'placeholder' => rl3('DB Prefix'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][external_dbs][#external_dbs#][prefix]']
							],
						],
					],
				],
			],
		]
	]);
?>