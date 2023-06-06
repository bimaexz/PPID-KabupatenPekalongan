<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\E\Chronoforms\C;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Logs extends \G3\A\E\Chronoforms\App {
	use \G3\A\C\T\DataOps;
	
	var $_models = array(
		'\G3\A\E\Chronoforms\M\Connection',
		'\G3\A\E\Chronoforms\M\Datalog',
	);

	var $_helpers = array(
		'\G3\A\E\Chronoforms\H\Field',
		'Parser' => '\G3\A\E\Chronoforms\H\Parser2',
	);
	
	function index(){
		if(!empty($this->data['form_id'])){
			$connection = $this->Connection->where('id', $this->data('form_id'))->select('first', ['json' => ['params', 'events', 'sections', 'views', 'functions', 'models', 'locales', 'rules']]);
			$this->set('connection', $connection);
			
			$this->Datalog->where('form_id', $this->data['form_id']);
			
			$this->Search($this->Datalog, ['user_id', 'ipaddress', 'created', 'data']);
			
			$this->Paginate($this->Datalog);
			$this->Order($this->Datalog, ['Datalog.aid', 'Datalog.created', 'Datalog.approved']);
			
			$this->Datalog->belongsTo('\G3\A\M\User', 'User', 'user_id');
			
			$records = $this->Datalog->select('all');
			$this->set('records', $records);
		}else{
			
		}
	}

	function tableindex(){
		$Table = new \G3\L\Model(['name' => 'Table', 'table' => $this->data('tablename')]);

		$this->Search($Table, $Table->tablefields);
			
		$this->Paginate($Table);
		$this->Order($Table, [$Table->pkey]);
		
		$records = $Table->select('all');
		$this->set('records', $records);
		$this->set('Table', $Table);

		$connection = $this->Connection->where('id', $this->data('form_id'))->select('first', ['json' => ['params', 'pages', 'views', 'functions']]);
		$this->set('connection', $connection);
	}

	function tabledelete(){
		$Table = new \G3\L\Model(['name' => 'Table', 'table' => $this->data('tablename')]);
		$Table->where($Table->pkey, $this->data('gcb'), 'in')->delete();

		\GApp3::session()->flash('success', rl3('Deleted Successfully'));
		$this->redirect(r3('index.php?ext=chronoforms&cont=logs&act=tableindex&tablename='.$this->data('tablename').'&form_id='));
	}

	function tableview(){
		$Table = new \G3\L\Model(['name' => 'Table', 'table' => $this->data('tablename')]);
		
		$record = $Table->where($Table->pkey, $this->data['aid'])->select('first');
		$this->set('record', $record);

		$connection = $this->Connection->where('id', $record['Datalog']['form_id'])->select('first', ['json' => ['params', 'pages', 'views', 'functions']]);
		$this->set('connection', $connection);
	}
	
	function view(){
		$this->Datalog->belongsTo('\G3\A\M\User', 'User', 'user_id');
		
		$record = $this->Datalog->where('aid', $this->data['aid'])->select('first', ['json' => ['data']]);
		$this->set('record', $record);

		$connection = $this->Connection->where('id', $record['Datalog']['form_id'])->select('first', ['json' => ['params', 'pages', 'views', 'functions']]);
		$this->set('connection', $connection);
	}
	
	function delete(){
		return $this->deleteRecord($this->Datalog);
	}
	
	function csv(){
		$connection = $this->Connection->where('id', $this->data('form_id'))->select('first', ['json' => ['params', 'pages', 'views', 'functions']]);
		
		if(!empty($this->data('gcb'))){
			$this->Datalog->where('aid', $this->data('gcb'), 'in');
		}
		
		$records = $this->Datalog->where('form_id', $this->data['form_id'])->select('all', ['json' => ['data']]);
		
		$titles = [];
		$rows = [];
		if(!empty($records)){
			foreach($records as $k => $record){
				//$record['Datalog']['data'] = json_decode($record['Datalog']['data'], true);
				foreach($record['Datalog'] as $dk => $dv){
					if($dk != 'data'){
						// $rows[$k][$dk] = $dv;
						if(!in_array($dk, $titles)){
							$titles[$dk] = $dk;
						}
					}else{
						foreach($dv as $dvk => $dvv){
							if(!empty($connection['Connection']['views'][$dvk])){
								$unit = $connection['Connection']['views'][$dvk];
								$title = !empty($unit['nodes']['label']['content']) ? $unit['nodes']['label']['content'] : $unit['wtitle'];
								if(!in_array($dvk, $titles)){
									$titles[$dvk] = $title;
								}
								// $rows[$k][$dvk] = is_array($dvv) ? json_encode($dvv, JSON_UNESCAPED_UNICODE) : $dvv;
							}
						}
					}
				}
				//$titles = array_unique(array_merge($titles, array_keys($data)));
			}
		}
		
		foreach($records as $k => $record){
			foreach($titles as $kt => $title){
				if(isset($record['Datalog'][$kt])){
					$rows[$k][$kt] = $record['Datalog'][$kt];
				}else{
					if(isset($record['Datalog']['data'][$kt]) AND is_array($record['Datalog']['data'][$kt])){
						$rows[$k][$kt] = json_encode($record['Datalog']['data'][$kt], JSON_UNESCAPED_UNICODE);
					}else{
						$rows[$k][$kt] = $record['Datalog']['data'][$kt] ?? '';
					}
				}
			}
		}
		array_unshift($rows, $titles);
		// pr($rows);die();
		\G3\L\Csv::build($rows, ',', 'D', $connection['Connection']['alias'].'.csv');
	}


	function file(){
		$path = $this->data('fname');
		$path = str_replace('..', '', $path);
		$path = $this->get('cf_settings.upload.path').$path;
		\G3\L\Download::send($path, 'D', basename($path));
	}
}
?>