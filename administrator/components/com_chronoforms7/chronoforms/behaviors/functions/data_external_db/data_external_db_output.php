<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($unit['dbconn'])){
		if(!empty($this->controller->FData->cdata('settings.form.external_dbs', []))){
			foreach($this->controller->FData->cdata('settings.form.external_dbs', []) as $db_conn){
				if($db_conn['alias'] == $unit['dbconn']){
					$unit['models']['data']['dbo'] = $db_conn;
				}
			}
		}
	}