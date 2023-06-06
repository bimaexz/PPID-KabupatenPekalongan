<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "layout",
		'title' => rl3("Layout"),
		'icon' => 'file-outline',
		'desc' => rl3("Select a Page Layout"),
		'group' => 'html',
		'category' => rl3("Advanced"),
		'triggers' => ['event','section_finish'],
		'order' => 0,
		"accept" => [
			"pages" => true,
		],
	];