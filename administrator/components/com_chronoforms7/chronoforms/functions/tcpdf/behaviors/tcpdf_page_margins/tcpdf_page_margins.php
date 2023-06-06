<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "tcpdf_page_margins",
		'title' => rl3("Page Margins"),
		'icon' => 'expand',
		'desc' => rl3("Set page margins"),
		'group' => 'data',
		'category' => rl3("Advanced"),
		'triggers' => [],
		'order' => 0,
		// 'default' => true,
		"accept" => [
			"functions" => [
				'tcpdf'
			],
		],
	];