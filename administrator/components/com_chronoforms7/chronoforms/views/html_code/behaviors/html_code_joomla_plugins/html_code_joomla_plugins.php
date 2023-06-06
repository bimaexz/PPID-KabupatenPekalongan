<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "html_code_joomla_plugins",
		'title' => rl3("Run Joomla Plugins"),
		'icon' => 'recycle',
		'desc' => rl3("Process the view content with the Joomla content plugins"),
		'group' => 'html_code',
		'category' => rl3("Advanced"),
		'triggers' => ['before_view'],
		'order' => 0,
		"accept" => [
			"views" => [
				"html_code",
			],
		],
		"paid" => 1,
	];