<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "form_description",
		'title' => rl3("Form Description"),
		'icon' => 'pencil-alt',
		'desc' => rl3("Form description is displayed in the forms manager"),
		'group' => 'admin',
		'category' => rl3("Settings"),
		'triggers' => [],
		'order' => 0,
		"accept" => [
			'settings' => true,
		],
	];