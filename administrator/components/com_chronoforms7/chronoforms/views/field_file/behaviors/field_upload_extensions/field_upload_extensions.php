<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_upload_extensions",
		'title' => rl3("Accepted Extensions & Size"),
		'icon' => 'upload',
		'desc' => rl3("List of file extensions and max file size"),
		'group' => 'field_file',
		'category' => rl3("Files"),
		'triggers' => [],
		'order' => -7,
		"accept" => [
			"ugroups" => ['files'],
		],
	];