<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if($this->controller->Page->check_page_type($page['pageid'], 'end')){
		$saved = [];
		$inputs = $this->controller->FData->inputs();

		foreach($inputs as $uid => $view){
			if(empty($view['dblog']['enabled'])){
				continue;
			}

			// $fname = $view['datapath'];
			foreach($view['datapath'] as $keysData => $dataname){
				if(is_numeric($keysData)){
					$saved[$uid] = $this->controller->Parser->parsev($view['uid'], 'db_log');
				}else{
					$keysData = json_decode($keysData, true);
					$saved = \G3\L\Arr::setVal($saved, array_merge([$uid], array_values($keysData)), $this->controller->Parser->parsev($view['uid'], 'db_log', $dataname));
					// foreach($keysData as $model => $key){
					// 	$saved[$uid][$key] = $this->controller->Parser->parsev($view['uid'], 'db_log', $dataname);
					// }
				}
			}
			// if(strpos($fname, '.#') !== false){
			// 	$mfnames = $this->controller->Parser->getNames($fname);
			// 	foreach($mfnames as $mk => $mfname){
			// 		$saved[$uid][$mk] = $this->controller->Parser->parsev($view['uid'], 'db_log', $mfname['name']);//$this->data($mfname['name']);
			// 	}
			// }else{
			// 	$saved[$uid] = $this->controller->Parser->parsev($view['uid'], 'db_log');//$this->data($fname);
			// }
			
			// $data_path = explode('.', $view['datapath'])[0];
			// $saved[$uid] = $this->data($data_path);
		}
		
		$saved['__loops'] = $this->data('__loops');
		
		$data = [
			'aid' => $this->controller->FData->sessiondata('log.aid'),
			'form_id' => $this->controller->FData->cdata('id'),
			'uid' => $this->controller->FData->sessiondata('log.uid', \G3\L\Str::uuid()),
			'user_id' => \GApp3::user()->get('id'),
			'created' => $this->controller->FData->sessiondata('log.created', \G3\L\Dater::datetime()),
			'modified' => $this->controller->FData->sessiondata('log.aid') ? \G3\L\Dater::datetime() : null,
			'ipaddress' => $_SERVER['REMOTE_ADDR'],
			'page' => $this->controller->FData->sessiondata('pages.requested', ''),
			//'data' => json_encode($saved, JSON_UNESCAPED_UNICODE),
		];
		
		// $save_data = [
		// 	'type' => 'save_data',
		// 	'name' => $page.'_datalog',
		// 	'db_table' => '#__chronoengine_forms7_datalog',
		// 	'model_name' => 'LOG',
		// 	'data_provider' => ($data + ['data' => json_encode($saved, JSON_UNESCAPED_UNICODE)]),
		// 	'action' => 'insert:update',
		// ];
		
		// $result = $this->event_function($page.'_datalog', $save_data);
		$source = ($data + ['data' => json_encode($saved, JSON_UNESCAPED_UNICODE)]);
		$Log = new \G3\A\E\Chronoforms\M\Datalog();
		$result = $Log->save($source, ['duplicate_update' => true]);
		
		if(!empty($result)){
			// $this->controller->FData->sessiondata('log', $this->get($page.'_datalog'), true);
			$this->set($page['fullname'].'_datalog', $Log->data);
			$this->controller->Page->debug[$page['fullname'].'_datalog']['data'] = $source;
		}
		
	}