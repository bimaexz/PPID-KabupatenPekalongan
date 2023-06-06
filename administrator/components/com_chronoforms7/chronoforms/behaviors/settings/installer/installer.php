<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "installer",
		'title' => rl3("Installer"),
		'icon' => 'plug',
		'desc' => rl3("Form Installer actions"),
		'group' => 'admin',
		'category' => rl3("Settings"),
		'triggers' => ["install"],
		'order' => 10,
		"accept" => [
			'settings' => true,
		],
	];