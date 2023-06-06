<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_delete",
		'title' => rl3("Delete"),
		'desc' => rl3("Delete the uploaded file after processing"),
		'group' => 'data',
		'category' => rl3("Files"),
		'icon' => 'trash',
		'triggers' => ['event'],
		'order' => 99,
		"accept" => [
			"ugroups" => ['files'],
		],
	];