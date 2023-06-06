<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$_map = [
		'main' => [
			'active' => true, 
			'tag' => 'span', 
			// 'children' => ['__CONTENT__'], 
			'attrs' => [
				'class' => ['default' => 'ui text']
			]
		],
		'container' => ['active' => true, 'children' => ['main'], 'attrs' => ['class' => ['default' => '']]]
	];

	echo $this->Field->build($view, $_map);