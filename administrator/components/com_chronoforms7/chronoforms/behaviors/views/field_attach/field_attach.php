<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_attach",
		'title' => rl3("Attach"),
		'desc' => rl3("Attach to Emails"),
		'group' => 'data',
		'category' => rl3("Files"),
		'icon' => 'paperclip',
		'default' => true,
		'triggers' => ['event'],
		'order' => -5,
		"accept" => [
			"ugroups" => ['files'],
		],
	];