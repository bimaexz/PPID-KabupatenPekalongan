<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "joomla_user_update",
		'title' => rl3("Update User"),
		'icon' => 'exclamation',
		'desc' => rl3("Update existing user conditions"),
		'group' => 'joomla_user',
		'category' => rl3("Advanced"),
		'triggers' => [],
		'order' => 0,
		// 'default' => true,
		"accept" => [
			"functions" => [
				'joomla_user'
			],
		],
	];