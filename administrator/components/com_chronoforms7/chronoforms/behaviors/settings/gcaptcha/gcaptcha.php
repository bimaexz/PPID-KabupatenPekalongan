<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "gcaptcha",
		'title' => rl3("reCaptcha Settings"),
		'icon' => 'brands:google',
		'desc' => rl3("Override the global reCaptcha keys"),
		'group' => 'configs',
		'category' => rl3("Settings"),
		'triggers' => [],
		'order' => -8,
		// 'default' => true,
		"accept" => [
			'settings' => true,
		],
	];