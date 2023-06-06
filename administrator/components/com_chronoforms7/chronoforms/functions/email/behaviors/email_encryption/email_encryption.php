<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "email_encryption",
		'title' => rl3("Encryption"),
		'icon' => 'key',
		'desc' => rl3("Encrypt Email Contents"),
		'group' => 'data',
		'category' => rl3("Advanced"),
		'triggers' => ['before_email'],
		'order' => 0,
		// 'default' => true,
		"accept" => [
			"functions" => [
				'email'
			],
		],
		"paid" => 1,
	];