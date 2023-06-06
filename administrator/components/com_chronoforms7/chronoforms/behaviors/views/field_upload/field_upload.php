<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_upload",
		'title' => rl3("Upload"),
		'icon' => 'upload',
		'desc' => rl3("Upload the file to server"),
		'group' => 'data',
		'category' => rl3("Files"),
		'default' => true,
		'triggers' => ['new_event_start'],
		'order' => -7,
		"accept" => [
			"ugroups" => ['files'],
		],
	];