<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['php_where'])){
		$where = eval($unit['php_where']);
		$unit['models']['data']['where'] = $where;
	}