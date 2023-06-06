<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	require(str_replace('functions', 'views', dirname(__FILE__)).DS.$behavior['name'].'_output.php');