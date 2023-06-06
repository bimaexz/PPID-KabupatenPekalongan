<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_alt_data",
		'title' => rl3("Alternative Data"),
		'icon' => 'keyboard',
		'desc' => rl3("Alternative field data"),
		'group' => 'data',
		'category' => rl3("Data"),
		'triggers' => ['new_event'],
		'order' => 0,
		//'global' => true,
		"accept" => [
			"ugroups" => ['inputs'],
		],
		"paid" => 1,
	];