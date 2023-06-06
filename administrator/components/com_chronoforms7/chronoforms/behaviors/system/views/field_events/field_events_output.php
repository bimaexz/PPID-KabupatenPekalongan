<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['vevents']) AND !empty($unit['fns']['validation']['fields'][$unit['uid']])){
		$disabled_actions = ['toggle_enable', 'disable', 'toggle_validation', 'disable_validation'];
		foreach($unit['vevents'] as $ek => $event){
			if(!empty($event['actions'])){
				if(!empty(array_intersect($disabled_actions, $event['actions']))){
					$unit['fns']['validation']['fields'][$unit['uid']]['server_disabled'] = true;
				}
			}
		}
	}