<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$gclient = [];

	$UserServiceAccount = new \G3\A\M\UserServiceAccount();
	$account = $UserServiceAccount->where('account_id', $function['account_id'])->select('first', ['json' => ['params']]);

	$gclient = $account['UserServiceAccount']['params'];

	$return = false;
	
	if(!empty($gclient)){
		$this->debug[$function['name']]['token'] = rl3('Access token found');


		$gsheets = new \G3\L\Services\Google\Sheets([
			'token' => $gclient['token'], 
			'scopes' => ['https://www.googleapis.com/auth/drive'], 
			'credentials' => $gclient['credentials'],
		]);

		if(!empty($function['items'])){
			$items = \G3\L\Arr::getVal($function['items'], '[n].pairs.[n].value', []);
			$values = [];
			foreach($items as $item){
				$item_data = [];
				foreach($item as $val){
					$item_data[] = $this->Parser->parse($val);
				}
				$values[] = $item_data;
			}
			$responseData = $gsheets->append($function['settings'], array_values($values));

			if(!empty($responseData['updates'])){
				$this->debug[$function['name']]['updated'] = $gsheets->msgs;
				$return = true;
			}
		}
	}else{
		$this->debug[$function['name']]['token'] = rl3('Error getting access token');
	}
	
	if($return === false){
		$this->fevents[$function['name']]['fail'] = true;
	}else{
		$this->fevents[$function['name']]['success'] = true;
	}

	$this->set($function['name'], $return);