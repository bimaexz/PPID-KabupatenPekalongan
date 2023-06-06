<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\C\T;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
trait Update {
	function sqlUpdate(){
		if(empty($this->data('tvout'))){
			$lastSQLupdate = filemtime(\G3\Globals::ext_path($this->extension, 'admin').'sql'.DS.'install.'.$this->extension.'.sql');
			$lastUpdateFlag = \GApp3::extension($this->extension)->settings()->get('sql_updated', 0);
			if($lastUpdateFlag < $lastSQLupdate){
				\GApp3::extension($this->extension)->settings()->set('sql_updated', time());
				\GApp3::extension($this->extension)->save_settings();
				$this->redirect(r3('index.php?ext='.$this->extension.'&cont=installer'));
			}
		}
	}
}