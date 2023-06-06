<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "email_php",
		'title' => rl3("PHP support"),
		'icon' => 'code',
		'desc' => rl3("Support PHP code in Email content"),
		'group' => 'data',
		'category' => rl3("Advanced"),
		'triggers' => ['before_function'],
		'order' => 0,
		// 'default' => true,
		"accept" => [
			"functions" => [
				'email'
			],
		],
		"paid" => 1,
	];