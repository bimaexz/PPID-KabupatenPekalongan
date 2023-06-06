<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\C\T;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
trait Permissions {
	
	function readPermissions($perms){
		$this->set('perms', $perms);
		
		$Group = new \G3\A\M\Group();
		$Acl = new \G3\A\M\Acl();
		//permissions groups
		$groups = array_merge([['Group' => ['id' => 'owner', 'title' => rl3('Owner'), '_depth' => 0]]], $Group->select('flat'));
		$this->set('groups', $groups);
		
		$acl = $Acl->where('aco', 'ext='.$this->extension)->select('first', ['json' => ['rules']]);
		if(!empty($acl)){
			$this->data = $acl;
		}
	}
	
	function savePermissions(){
		if(empty($this->data['Acl'])){
			$this->redirect(r3('index.php?ext='.$this->extension.'&act=permissions'));
		}
		$Acl = new \G3\A\M\Acl();
		
		$this->data['Acl']['title'] = $this->extension;
		$this->data['Acl']['aco'] = 'ext='.$this->extension;
		$this->data['Acl']['enabled'] = 1;
		$result = $Acl->save($this->data['Acl'], ['json' => ['rules']]);
		
		if($result !== false){
			\GApp3::session()->flash('success', rl3('Permissions updated successfully.'));
		}else{
			\GApp3::session()->flash('error', rl3('Error updating permissions.'));
		}
		
		$this->redirect(r3('index.php?ext='.$this->extension.'&act=permissions'));
	}
	
}
?>