<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\C;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Acls extends \G3\A\App {
	use \G3\A\C\T\DataOps;
	
	var $_models = array(
		'\G3\A\M\AclProfile',
		'\G3\A\M\Group'
	);
	
	function index(){
		//search
		$this->Search($this->AclProfile, ['title', 'acls']);
		
		$this->Paginate($this->AclProfile);
		
		$this->Order($this->AclProfile, ['acl_title' => 'AclProfile.title', 'acl_id' => 'AclProfile.id', 'acl_enabled' => 'AclProfile.enabled']);
		
		$acls = $this->AclProfile->select('all', ['json' => ['acls']]);
		$this->set('acls', $acls);
	}
	
	function edit(){
		
		if(isset($this->data['save']) OR isset($this->data['apply'])){
			$result = false;
			
			if(!empty($this->data['AclProfile'])){
				$result = $this->AclProfile->save($this->data['AclProfile'], ['validate' => true, 'alias' => ['title' => 'alias'], 'json' => ['rules']]);
			}
			
			if($result === true){
				
				if(isset($this->data['apply'])){
					$redirect = r3('index.php?ext='.$this->extension.'&cont=acls&act=edit&id='.$this->AclProfile->id);
				}else{
					$redirect = r3('index.php?ext='.$this->extension.'&cont=acls');
				}
				return ['success' => rl3('AclProfile updated successfully.'), 'redirect' => $redirect];
			}else{
				
				$this->errors['AclProfile'] = $this->AclProfile->errors;
				unset($this->data['save']);
				unset($this->data['apply']);
				return ['error' => $this->AclProfile->errors, 'reload' => true];
			}
		}
		
		if(!empty($this->data['id'])){
			$acl = $this->AclProfile->where('id', $this->data('id', null))->select('first', ['json' => ['rules']]);
			if(!empty($acl)){
				$this->data = array_merge($this->data, $acl);
			}
			
			$this->set('acl', $acl);
		}

		//get users groups for permissions
		$_groups = $this->Group->select('flat');
		$this->set('_groups', $_groups);
		$groups = array_merge([['Group' => ['id' => 'owner', 'title' => rl3('Owner'), '_parents' => []]]], $_groups);
		$this->set('groups', $groups);
	}
	
	function toggle(){
		return $this->toggleRecord($this->AclProfile);
	}
	
	function delete(){
		return $this->deleteRecord($this->AclProfile);
	}

}
?>