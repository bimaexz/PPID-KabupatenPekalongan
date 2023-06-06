<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_noautocomplete",
		'title' => rl3("No AutoComplete"),
		'desc' => rl3("Disable the browser auto complete for this field"),
		'group' => 'html',
		'category' => rl3("Settings"),
		'icon' => 'keyboard',
		'triggers' => ['before_view'],
		'order' => 9,
		"accept" => [
			"ugroups" => ['inputs'],
		],
		"not_accept" => [
			"ugroups" => ['hidden'],
		],
	];