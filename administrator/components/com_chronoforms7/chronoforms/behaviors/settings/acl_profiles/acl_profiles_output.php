<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['acl_profiles'])){
		$acl = [
			'enabled' => 1,
			'rules' => [],
		];

		foreach($unit['acl_profiles'] as $profile){
			if(!empty($profile['alias'])){
				
				$arules = [];
				if(!empty($profile['allowed_groups'])){
					foreach($profile['allowed_groups'] as $group){
						$acl['rules'][$group] = 1;
					}
				}
				if(!empty($profile['denied_groups'])){
					foreach($profile['denied_groups'] as $group){
						$acl['rules'][$group] = -1;
					}
				}
				
				$this->controller->FData->cdata('acls.'.$profile['alias'], $acl, true);
			}
		}
	}