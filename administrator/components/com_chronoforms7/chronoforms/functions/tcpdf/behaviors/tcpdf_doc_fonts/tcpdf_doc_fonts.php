<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "tcpdf_doc_fonts",
		'title' => rl3("Fonts"),
		'icon' => 'font',
		'desc' => rl3("Set the document text fonts"),
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