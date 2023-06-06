<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "email_cc_bcc",
		'title' => rl3("CC/BCC Addresses"),
		'icon' => 'envelope',
		'desc' => rl3("Configure the Email CC/BCC Addresses"),
		'group' => 'data',
		'category' => rl3("Advanced"),
		'triggers' => [],
		'order' => 0,
		// 'default' => true,
		"accept" => [
			"functions" => [
				'email'
			],
		],
	];