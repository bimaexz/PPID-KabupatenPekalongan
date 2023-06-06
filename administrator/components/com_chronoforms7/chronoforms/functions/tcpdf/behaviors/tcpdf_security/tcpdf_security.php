<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "tcpdf_security",
		'title' => rl3("Security"),
		'icon' => 'key',
		'desc' => rl3("Set document password"),
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