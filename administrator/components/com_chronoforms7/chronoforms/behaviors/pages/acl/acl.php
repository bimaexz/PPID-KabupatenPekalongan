<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "acl",
		'title' => rl3("ACL"),
		'icon' => 'shield-alt',
		'desc' => rl3("Apply ACL rules to this unit"),
		'group' => 'data',
		'category' => rl3("Advanced"),
		'triggers' => ['initialize_event'],
		'order' => 0,
		"accept" => [
			"pages" => true,
		],
		"paid" => 1,
	];