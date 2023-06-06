<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$unit['models']['data']['paging'] = true;

	if(!empty($unit['models']['data']['paging_reset'])){
		foreach($unit['models']['data']['paging_reset'] as $paging_reset_field){
			$request_search_term = \G3\L\Request::post($paging_reset_field['field'], \G3\L\Request::get($paging_reset_field['field']));

			if(!is_null($request_search_term)){
				\G3\L\Request::set('startat', 0);
			}
		}
	}