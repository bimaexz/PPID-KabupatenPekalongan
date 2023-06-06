<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "joomla_user_custom_fields",
		'title' => rl3("Custom Fields"),
		'icon' => 'book',
		'desc' => rl3("Update the user custom fields"),
		'group' => 'joomla_user',
		'category' => rl3("Advanced"),
		'triggers' => [],
		'order' => 1,
		// 'default' => true,
		"accept" => [
			"functions" => [
				'joomla_user',
			],
		],
	];