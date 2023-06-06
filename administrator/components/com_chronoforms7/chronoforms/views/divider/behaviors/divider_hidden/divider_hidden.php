<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "divider_hidden",
		'title' => rl3("Hidden"),
		'icon' => 'eye slash',
		'desc' => rl3("Hide the divider line but keep the space"),
		'group' => 'divider',
		'category' => rl3("Advanced"),
		'triggers' => ['before_view'],
		'order' => 0,
		"accept" => [
			"views" => [
				"divider",
			],
		],
	];