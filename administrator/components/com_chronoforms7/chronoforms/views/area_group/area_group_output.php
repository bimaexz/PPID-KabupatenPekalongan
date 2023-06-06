<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$_map = [
		'main' => ['active' => false, 'children' => ['content' => $this->Parser->section($view['uid'].'/body')]],
	];

	echo $this->Field->build($view, $_map);
?>