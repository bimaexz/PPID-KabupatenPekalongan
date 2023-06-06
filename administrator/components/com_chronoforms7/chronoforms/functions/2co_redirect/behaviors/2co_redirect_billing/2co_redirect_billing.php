<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "2co_redirect_billing",
		'title' => rl3("Billing Information"),
		'icon' => 'user',
		'desc' => rl3("Configure the Order billing information"),
		'group' => '2co_redirect',
		'category' => rl3("Advanced"),
		'triggers' => [],
		'order' => 0,
		// 'default' => true,
		"accept" => [
			"functions" => [
				'2co_redirect'
			],
		],
	];