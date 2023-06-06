<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "connected_tables",
		'title' => rl3("Connected Tables"),
		'icon' => 'table',
		'desc' => rl3("List of database tables connected to this form and listed in the forms manager"),
		'group' => 'admin',
		'category' => rl3("Settings"),
		'triggers' => ["install"],
		'order' => 10,
		"accept" => [
			'settings' => true,
		],
	];