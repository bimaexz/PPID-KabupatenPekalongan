<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "user_email",
		'title' => rl3("User Email"),
		'icon' => 'paper-plane',
		'desc' => rl3("Send email to the user"),
		'group' => 'data',
		'category' => rl3("Settings"),
		'triggers' => ["event_finish"],
		'order' => 0,
		"accept" => [
			'settings' => true,
		],
		"paid" => 1,
	];