<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		"name" => "joomla_user_activation",
		"title" => rl3("User activation"),
		"icon" => "checkmark",
		"desc" => rl3(""),
		"group" => "Joomla",
		"order" => 0,
		"areas" => ["success" => "green","fail" => "red",],
		"apps" => ["xforms"],
	];