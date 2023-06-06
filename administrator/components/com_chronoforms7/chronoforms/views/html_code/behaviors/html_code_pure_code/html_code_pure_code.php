<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "html_code_pure_code",
		'title' => rl3("Pure Code"),
		'icon' => 'code',
		'desc' => rl3("Output the code only, without a div container"),
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