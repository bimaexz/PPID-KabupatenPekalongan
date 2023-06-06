<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$_map = [
		//'main' => ['children' => ['icon']],
		'container' => ['children' => ['main'], 'active' => false],
	];
	echo $this->Field->build($view, $_map);