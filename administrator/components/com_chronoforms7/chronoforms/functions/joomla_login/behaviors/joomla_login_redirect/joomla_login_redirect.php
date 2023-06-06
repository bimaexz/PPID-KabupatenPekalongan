<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "joomla_login_redirect",
		'title' => rl3("Redirect"),
		'icon' => 'brands:joomla',
		'desc' => rl3("Redirect to the user to the default Joomla login"),
		'group' => 'data',
		'category' => rl3("Advanced"),
		'triggers' => ['before_function'],
		'order' => 0,
		// 'default' => true,
		"accept" => [
			"functions" => [
				'joomla_login'
			],
		],
	];