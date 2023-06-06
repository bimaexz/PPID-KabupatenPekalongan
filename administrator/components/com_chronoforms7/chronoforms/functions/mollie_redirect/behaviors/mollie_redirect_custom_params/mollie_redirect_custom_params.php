<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "mollie_redirect_custom_params",
		'title' => rl3("Custom Parameters"),
		'icon' => 'keyboard',
		'desc' => rl3("Pass custom parameters to the gateway"),
		'group' => 'mollie_redirect',
		'category' => rl3("Advanced"),
		'triggers' => [],
		'order' => 0,
		// 'default' => true,
		"accept" => [
			"functions" => [
				'mollie_redirect'
			],
		],
	];