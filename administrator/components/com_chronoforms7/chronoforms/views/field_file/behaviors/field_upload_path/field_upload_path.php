<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_upload_path",
		'title' => rl3("Custom upload path"),
		'icon' => 'upload',
		'desc' => rl3("Change the default upload path of this field files"),
		'group' => 'field_file',
		'category' => rl3("Files"),
		'triggers' => [],
		'order' => -7,
		"accept" => [
			"ugroups" => ['files'],
		],
	];