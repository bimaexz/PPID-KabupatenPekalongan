<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	return [
		'name' => "field_listing_search",
		'title' => rl3("Search Listing"),
		'icon' => 'search',
		'desc' => rl3("Use as a Listing Search Field"),
		'group' => 'data',
		'category' => rl3("Advanced"),
		'triggers' => ['event'],
		'order' => 0,
		"accept" => [
			"views" => [
				'field_text',
				'field_select',
				'field_radios',
			],
		],
	];