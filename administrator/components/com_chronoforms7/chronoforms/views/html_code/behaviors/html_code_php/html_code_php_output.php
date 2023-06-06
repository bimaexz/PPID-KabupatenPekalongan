<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	ob_start();
	eval('?>'.$unit['nodes']['main']['content']);
	$unit['nodes']['main']['d_content'] = ob_get_clean();