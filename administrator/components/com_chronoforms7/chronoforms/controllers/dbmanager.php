<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\E\Chronoforms\C;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Dbmanager extends \G3\A\E\Chronoforms\App {
	use \G3\A\C\T\DataOps;

	var $_libs = array(
		
	);
	
	var $_models = array(
		
	);
	
	var $_helpers = array(
		
	);

	function mui(){
		
	}

	function index(){
		$dbo = \G3\L\Database::getInstance([]);
		// $db_tables = $dbo->getTablesList();

		$q = "SELECT
		table_schema as `Database`,
		table_name AS `name`,
		table_rows AS `rows`,
		table_collation AS `collation`,
		engine AS `engine`,
		round(((data_length + index_length) / 1024 ), 2) `size`
   		FROM information_schema.TABLES
   		WHERE table_schema = '".$dbo->db_name."';";
		
		$dbo->adapter->setQuery($q);
		$db_tables = $dbo->adapter->loadAssocList();

		$this->set('tables', $db_tables);

		$this->set('db', $dbo->db_name);
	}

	function browse_table(){
		$dbo = \G3\L\Database::getInstance([]);

		$columns = $dbo->getTableInfo($this->data('table'), true);

		$this->set('uid', $dbo->getTablePrimary($this->data('table'), true));

		$this->set('columns', $columns);
		$this->set('table', $this->data('table'));
		$this->set('db', $dbo->db_name);

		$Table = new \G3\L\Model(['name' => 'Record', 'table' => $this->data('table')]);
		//search
		$this->Search($Table, \G3\L\Arr::getVal($columns, ['[n]', 'name']));
		//paginate
		$this->Paginate($Table);
		//sort
		$this->Order($Table, \G3\L\Arr::getVal($columns, ['[n]', 'name']));

		$sqllog = $dbo->log;

		$rows = $Table->select('all');

		$this->set('rows', $rows);

		$sql = array_values(array_diff($dbo->log, $sqllog));
		$this->set('sql', $sql);
	}

	function structure_table(){
		$dbo = \G3\L\Database::getInstance([]);

		$columns = $dbo->getTableInfo($this->data('table'), true);

		$this->set('uid', $dbo->getTablePrimary($this->data('table'), true));

		$this->set('columns', $columns);
		$this->set('table', $this->data('table'));
		$this->set('db', $dbo->db_name);
	}

	function insert_row(){
		$result = $this->_process_row('insert');
		return $result;
	}

	function edit_row(){
		$result = $this->_process_row('edit');
		return $result;
	}

	function copy_row(){
		$result = $this->_process_row('copy');
		return $result;
	}

	function _process_row($act = 'edit'){
		$dbo = \G3\L\Database::getInstance([]);

		$uid = $dbo->getTablePrimary($this->data('table'), true);
		$rid = $this->data('rid');

		$Table = new \G3\L\Model(['name' => 'Record', 'table' => $this->data('table')]);

		$columns = $dbo->getTableInfo($this->data('table'), true);

		$this->set('columns', $columns);
		$this->set('table', $this->data('table'));
		$this->set('db', $dbo->db_name);

		if(!empty($this->data('confirm')) AND !empty($this->data('Record'))){
			$dset = [];
			foreach($this->data('Record') as $field => $fdata){
				if(empty($fdata['null'])){
					$dset[$field] = $fdata['value'];
				}else{
					$dset[$field] = null;
				}
			}

			if(!empty($dset)){
				if($act == 'edit'){
					unset($dset[$uid]);
					$result = $Table->where($uid, $rid)->update($dset);

					$msg = rl3('Row updated successfully.');
				}else if($act == 'copy'){
					unset($dset[$uid]);
					$result = $Table->insert($dset);

					$msg = rl3('Row saved successfully.');
				}else if($act == 'insert'){
					$result = $Table->insert($dset);

					$msg = rl3('Row saved successfully.');
				}

				if($result){
					$redirect = r3('index.php?ext=chronoforms&cont=dbmanager&act=browse_table&db='.$dbo->db_name.'&table='.$this->data('table'));

					return ['success' => $msg, 'redirect' => $redirect];
				}else{
					$this->errors['Table'] = $Table->errors;
					unset($this->data['confirm']);
					return ['error' => $Table->errors, 'reload' => true];
				}
			}
		}
		
		if($act != 'insert'){
			$row = $Table->where($uid, $rid)->select('first');
			
			foreach($columns as $column){
				$cname = $column['name'];
				if(!isset($row['Record'][$column['name']])){
					$this->data['Record'][$column['name']]['null'] = 1;
				}else{
					$this->data['Record'][$column['name']]['value'] = $row['Record'][$column['name']];
				}
			}
		}

		if($act == 'copy'){
			unset($this->data['Record'][$uid]);
		}

		$this->view = 'edit_row';
	}

	function delete_row(){
		$dbo = \G3\L\Database::getInstance([]);

		$uid = $dbo->getTablePrimary($this->data('table'), true);
		$rid = (array)$this->data('rid');

		$Table = new \G3\L\Model(['name' => 'Record', 'table' => $this->data('table')]);

		if(!empty($this->data('confirm'))){
			$result = $Table->where($uid, $rid, 'in')->delete();

			if($result){
				$redirect = r3('index.php?ext=chronoforms&cont=dbmanager&act=browse_table&db='.$dbo->db_name.'&table='.$this->data('table'));

				return ['success' => rl3('Row(s) deleted successfully'), 'redirect' => $redirect];
			}else{
				$this->errors['Table'] = $Table->errors;
				return ['error' => $Table->errors, 'reload' => true];
			}
		}

		$this->set('rids', $rid);
		$this->set('uid', $uid);
		$this->set('table', $this->data('table'));
		$this->set('db', $dbo->db_name);
	}

	function search_table(){
		$dbo = \G3\L\Database::getInstance([]);

		$Table = new \G3\L\Model(['name' => 'Record', 'table' => $this->data('table')]);

		$columns = $dbo->getTableInfo($this->data('table'), true);

		$this->set('columns', $columns);
		$this->set('table', $this->data('table'));
		$this->set('db', $dbo->db_name);

		if(!empty($this->data('search')) AND !empty($this->data('Record'))){
			$sset = [];
			foreach($this->data('Record') as $field => $fdata){
				if(!empty($fdata['op'])){
					// $Table->where($field, $fdata['value'], $fdata['op']);
					$sset['_search'][$field][$fdata['op']] = $fdata['value'];
				}
			}

			if(!empty($sset)){
				$redirect = \G3\L\Url::build(r3('index.php?ext=chronoforms&cont=dbmanager&act=browse_table&db='.$dbo->db_name.'&table='.$this->data('table')), $sset);

				return ['redirect' => $redirect];
			}
			
		}
	}

}
?>