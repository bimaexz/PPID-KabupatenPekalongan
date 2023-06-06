<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if($this->controller->Page->check_page_type($page['pageid'], 'end')){
		$saved = [];
		$inputs = $this->controller->FData->inputs();

		$data = [
			'uid' => $this->controller->FData->sessiondata('log.uid', \G3\L\Str::uuid()),
			'user_id' => \GApp3::user()->get('id'),
			'created' => $this->controller->FData->sessiondata('log.created', \G3\L\Dater::datetime()),
			'modified' => $this->controller->FData->sessiondata('log.aid') ? \G3\L\Dater::datetime() : null,
			'ipaddress' => $_SERVER['REMOTE_ADDR'],
			'page' => $this->controller->FData->sessiondata('pages.requested', ''),
		];
		
		foreach($inputs as $uid => $view){
			if(empty($view['dbtable']['enabled'])){
				continue;
			}
			
			$data['u_'.$uid] = $this->data($view['datapath']);
		}

		$tablename = $this->controller->FData->cdata('settings.form.log_table.tablename');

		if(!empty($tablename)){
			$Table = new \G3\L\Model(['name' => 'Table', 'table' => $tablename]);
			
			$result = $Table->insert($data);
			
			if(!empty($result)){
				$this->set($page['fullname'].'_tablelog', $Table->data);
				$this->controller->Page->debug[$page['fullname'].'_tablelog']['data'] = $data;
			}else{
				$this->set($page['fullname'].'_tablelog', $result);
			}
		}
		
	}