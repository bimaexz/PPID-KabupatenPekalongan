<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['inherits'])){
		$target = $this->controller->FData->cdata($unit['utype'].'.'.$unit['inherits']);
		// pr($target);
		if(isset($target['invalid'])){
			unset($target['invalid']);
		}
		// pr($unit);
		$mixunit = array_replace_recursive($target, $unit);
		// pr($mixunit);
		foreach($mixunit as $key => $value){
			if(is_array($value)){
				if($key == 'behaviors'){
					foreach($mixunit[$key] as $bg => $bgdata){
						$mixunit[$key][$bg] = array_unique(array_merge($target[$key][$bg] ?? [], $mixunit[$key][$bg]));
					}
				}else{
					if(strpos($key, '_') !== 0){// do not merge internal vars
						if(in_array($key, ['acl', 'conditions', 'localvars', 'datapath'])){
							$mixunit[$key] = $unit[$key] ?? $target[$key];
						}else{
							if(!empty($target[$key]) AND !empty($unit[$key])){
								// this line causes a problem with options, if one field has options 1,2,3 but the other has 4,5 then there is duplication because of the earlier array_replace_recursive
								// $mixunit[$key] = array_merge($target[$key] ?? [], $mixunit[$key]);
							}
						}
					}
				}
			}
		}
		$unit = $mixunit;
		
		// pr($mixunit);
	}