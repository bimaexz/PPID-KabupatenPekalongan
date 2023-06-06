<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "group_permissions",
		'title' => rl3("Local Permissions"),
		'icon' => 'shield-alt',
		'desc' => rl3("Control groups access to this unit"),
		'group' => 'data',
		'category' => rl3("Advanced"),
		'triggers' => ['initialize'],
		'order' => -999,
		'config_order' => 10,
		//'global' => true,
		"accept" => [
			"functions" => true,
		],
	];