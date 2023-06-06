<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\C;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class ServiceAccounts extends \G3\A\App {

	var $_models = ['\G3\A\M\UserServiceAccount'];
	
	function index(){
		//search
		$this->Search($this->UserServiceAccount, ['title', 'account_id']);
		
		$this->Paginate($this->UserServiceAccount);
		
		$this->Order($this->UserServiceAccount, ['acl_title' => 'UserServiceAccount.title', 'acl_id' => 'UserServiceAccount.id', 'acl_enabled' => 'UserServiceAccount.enabled']);
		
		$accounts = $this->UserServiceAccount->select('all', ['json' => ['params']]);
		$this->set('accounts', $accounts);
	}
	
	function edit(){
		if(isset($this->data['save']) OR isset($this->data['apply'])){
			$result = false;

			if(!empty($this->data('complete_save'))){
				$this->data['UserServiceAccount'] = \GApp3::session()->get('service_account_data', []);
			}else{
				\GApp3::session()->set('service_account_data', $this->data['UserServiceAccount']);
				$this->start_google_authorization($this->data['UserServiceAccount']);
			}
			
			if(!empty($this->data['UserServiceAccount'])){
				$result = $this->UserServiceAccount->save($this->data['UserServiceAccount'], ['validate' => true, 'alias' => ['title' => 'alias'], 'json' => ['params']]);
			}
			
			if($result === true){
				
				if(isset($this->data['apply'])){
					$redirect = r3('index.php?ext='.$this->extension.'&cont=service_accounts&act=edit&id='.$this->UserServiceAccount->id);
				}else{
					$redirect = r3('index.php?ext='.$this->extension.'&cont=service_accounts');
				}
				return ['success' => rl3('UserServiceAccount updated successfully.'), 'redirect' => $redirect];
			}else{
				
				$this->errors['UserServiceAccount'] = $this->UserServiceAccount->errors;
				unset($this->data['save']);
				unset($this->data['apply']);
				return ['error' => $this->UserServiceAccount->errors, 'reload' => true];
			}
		}
		
		if(!empty($this->data['id'])){
			$account = $this->UserServiceAccount->where('id', $this->data('id', null))->select('first', ['json' => ['params']]);
			if(!empty($account)){
				$this->data = array_merge($this->data, $account);
			}
			
			$this->set('account', $account);
		}
	}
	
	function toggle(){
		return $this->toggleRecord($this->UserServiceAccount);
	}
	
	function delete(){
		return $this->deleteRecord($this->UserServiceAccount);
	}


	function start_google_authorization($account){
		if(!empty($account['params']['credentials'])){
			$client_id = $account['params'];
			
			\GApp3::session()->set('google_client_id', $client_id);
			
			$client_id['listener_uri'] = r3('index.php?ext='.$this->extension.'&cont=service_accounts&act=save_google_authorization', ['full' => true]);
			$client_id['refresh'] = true;
			$token = \G3\L\Services\Google\Auth::getToken($client_id);
		}
	}

	function save_google_authorization(){
		if(!empty(\GApp3::session()->get('google_client_id'))){
			$client_id = \GApp3::session()->get('google_client_id');
			$token = \G3\L\Services\Google\Auth::getToken(\GApp3::session()->get('google_client_id'));
			if(!empty($client_id)){
				$client_id['token'] = json_encode($token);
				
				\GApp3::session()->set('service_account_data.params', $client_id);

				$this->redirect(r3('index.php?ext='.$this->extension.'&cont=service_accounts&act=edit&apply=1&complete_save=1'));
			}
		}
	}
	
}
?>