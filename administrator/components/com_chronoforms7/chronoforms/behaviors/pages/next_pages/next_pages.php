<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "next_pages",
		'title' => rl3("Next Pages"),
		'icon' => 'arrow-right',
		'desc' => rl3("Define a list of permitted next pages"),
		'group' => 'html',
		'category' => rl3("Advanced"),
		'triggers' => [],
		'order' => 0,
		"accept" => [
			"pages" => true,
		],
	];