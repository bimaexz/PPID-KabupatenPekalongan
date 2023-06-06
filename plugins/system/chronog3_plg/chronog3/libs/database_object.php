<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\L;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class DatabaseObject {
	var $db_user = null;
	var $db_pass = null;
	var $db_name = null;
	var $db_host = null;
	var $db_type = null;
	var $db_prefix = null;
	var $log = array();
	var $connected = false;
	var $error = null;
	var $descriptions = array();
	var $adapter = null;
	var $processor = null;
	
	public static function getInstance($options = array()){
		if(!empty($options)){
			$db_adapter_class = \G3\Globals::getClass('database_adapter');
			$new_object = new $db_adapter_class($options);
			$new_object->_initialize($options);
			
			//$db_processor_class = '\G3\L\DatabaseProcessors\\'.Str::camilize($new_object->db_type);
			//$new_object->processor = new $db_processor_class();
			return $new_object;
		}else{
			return false;
		}
	}
	
	function get_reserved_words(){
		return array('LIKE', 'ASC', 'DESC', 'OR', 'AND');
	}
	
	private function _initialize($options){
		$this->db_prefix = $options['prefix'];
		$this->db_user = $options['user'];
		$this->db_pass = $options['pass'];
		$this->db_name = $options['name'];
		$this->db_host = $options['host'];
		$this->db_type = $options['type'];
	}
	
	function prefix($tablename = ''){
		if(empty($tablename)){
			return $this->db_prefix;
		}else{
			return $this->db_prefix.$tablename;
		}
	}
	
	function _prefixTable($sql){
		$sql = str_replace(['#__', '#ce__'], [$this->db_prefix, $this->db_prefix.'chronog3_'], $sql);
		return $sql;
	}

	function tableExists($tablename){
		$tablename = $this->_prefixTable($tablename);
		$db_tables = $this->getTablesList();
		
		return in_array($tablename, $db_tables);
	}
	
	function createTable($tablename){
		$tablename = $this->_prefixTable($tablename);
		$db_tables = $this->getTablesList();
		
		if(!in_array($tablename, $db_tables)){
			$rows = [];
			$rows[] = '`aid` int(11) NOT NULL AUTO_INCREMENT';
			
			if(empty($model['layout'])){
				$rows[] = '`uid` varchar(50) NOT NULL';
				$rows[] = '`user_id` int(11) NOT NULL';
				$rows[] = "`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'";
				$rows[] = '`modified` datetime DEFAULT NULL';
			}else if($model['layout'] == 'custom'){
				
			}
			
			$rows[] = 'PRIMARY KEY (`aid`)';
			$rows = array('CREATE TABLE IF NOT EXISTS `'.$tablename.'` (', implode(",\n", $rows));
			$rows[] = ') DEFAULT CHARSET=utf8;';
			$sql = implode("\n", $rows);
			$sql = $this->_prefixTable($sql);
			$this->exec($sql);
		}
		
	}
	
	function _close($sql){
		return $sql.";";
	}
	
	function _log($sql, $params = array()){
		foreach($params as $k => $v){
			$sql = preg_replace('/:'.$k.'( |,|;|\))/', "'".$v."'$1", $sql);
		}
		$this->log[] = $sql;
	}
	
	function quoteName($string, $q = '`'){
		return $q.trim($string, $q).$q;
	}
	
	function getTablesList(){
		return array();
	}
	
	function getTableInfo($tablename, $formatted = false){
		if(isset($this->descriptions[$tablename])){
			$result = $this->descriptions[$tablename];
		}else{
			$this->descriptions[$tablename] = $result = $this->_getTableInfo($tablename);
		}

		if(!$formatted){
			return $result;
		}
		
		$fields = [];
		foreach($result as $k => $field){
			$fields[$k]['name'] = $field['Field'];
			$fields[$k]['null'] = $field['Null'] == 'NO' ? false : true;
			$fields[$k]['default'] = $field['Default'];
			$fields[$k]['key'] = $field['Key'];
			$fields[$k]['type'] = explode('(', explode(' ', $field['Type'], 2)[0], 2)[0];
			$fields[$k]['length'] = strpos($field['Type'], '(') !== false ? trim(explode('(', explode(' ', $field['Type'], 2)[0], 2)[1], ')') : '';
			$fields[$k]['attrs'] = strpos($field['Type'], 'unsigned') ? 'unsigned' : '';
			$fields[$k]['AI'] = $field['Extra'] == 'auto_increment' ? true : false;
		}

		return $fields;
	}
	
	function getTableColumns($tablename){
		$columns = array();
		if(isset($this->descriptions[$tablename])){
			$result = $this->descriptions[$tablename];
		}else{
			$this->descriptions[$tablename] = $result = $this->_getTableInfo($tablename);
		}
		foreach($result as $r){
			$columns[] = $r['Field'];
		}
		return $columns;
	}
	
	function getTablePrimary($tablename, $unique = false){
		if(isset($this->descriptions[$tablename])){
			$result = $this->descriptions[$tablename];
		}else{
			$this->descriptions[$tablename] = $result = $this->_getTableInfo($tablename);
		}
		foreach($result as $r){
			if($r['Key'] == 'PRI'){
				return $r['Field'];
			}
		}

		if($unique){
			foreach($result as $r){
				if($r['Key'] == 'UNI'){
					return $r['Field'];
				}
			}
		}

		return null;
	}

	function getTableKeys($tablename){
		if(isset($this->descriptions[$tablename])){
			$result = $this->descriptions[$tablename];
		}else{
			$this->descriptions[$tablename] = $result = $this->_getTableInfo($tablename);
		}

		$results = [];
		foreach($result as $r){
			if($r['Key'] == 'PRI'){
				$results['PRI'] = $r['Field'];
			}else if($r['Key'] == 'UNI'){
				$results['UNI'][] = $r['Field'];
			}
		}

		return $results;
	}
	
	function dropTableField($tablename, $name){
		return $this->exec('ALTER TABLE '.$this->quoteName($this->_prefixTable($tablename)).' DROP '.$this->quoteName($name).';');
	}
	
	function addTableField($tablename, $name, $params){
		$length = !empty($params['length']) ? '( '.$params['length'].' )' : '';
		$null = (!empty($params['null']) OR (!empty($params['default']) AND ($params['default'] == 'NULL'))) ? 'NULL' : 'NOT NULL';
		$default = (isset($params['default']) AND strlen($params['default']) AND $null !== 'NULL') ? "DEFAULT '".$params['default']."'" : '';
		$ai = (!empty($params['AI']) ? "AUTO_INCREMENT" : '');

		return $this->exec('ALTER TABLE '.$this->quoteName($this->_prefixTable($tablename)).' ADD '.$this->quoteName($name).' '.$params['type'].$length." ".$null." ".$default." ".$ai.";");
	}

	function keyTableField($tablename, $name, $key){
		$drop = '';
		$fields = $this->_getTableInfo($this->_prefixTable($tablename));
		foreach($fields as $field){
			if($field['Field'] == $name){
				if(!empty($field['Key'])){
					return false;
				}
			}
		}
		
		return $this->exec('ALTER TABLE '.$this->quoteName($this->_prefixTable($tablename)).' ADD '.$key.'('.$this->quoteName($name).');');
	}
	
	function alterTableField($tablename, $name, $newName, $params = []){
		if(empty($params)){
			$fields = $this->_getTableInfo($this->_prefixTable($tablename));
			foreach($fields as $field){
				if($field['Field'] == $name){
					$params['type'] = $field['Type'];
					$params['null'] = ($field['Null'] == 'NO') ? false : true;
					$params['default'] = $field['Default'];
					break;
				}
			}
		}
		
		$length = !empty($params['length']) ? '( '.$params['length'].' )' : '';
		$null = !empty($params['null']) ? 'NULL' : 'NOT NULL';
		$default = (isset($params['default']) AND strlen($params['default']) AND $null !== 'NULL') ? "DEFAULT '".$params['default']."'" : '';
		$ai = (!empty($params['AI']) ? "AUTO_INCREMENT" : '');
		
		$sql = 'ALTER TABLE '.$this->quoteName($this->_prefixTable($tablename)).' CHANGE '.$this->quoteName($name).' '.$this->quoteName($newName).' '.$params['type'].$length." ".$null." ".$default." ".$ai.";";
		
		return $this->exec($sql);
	}
	
	//end dependent stuff
	
	function run($sql, $params = array(), $driver_options = array()){
		return 0;
	}
	
	function load($sql, $params = array(), $driver_options = array()){
		return false;
	}
	
	function loadObject($sql, $params = array()){
		return array();
	}
	
	function loadObjectList($sql, $params = array()){
		return array();
	}
	
	function loadAssoc($sql, $params = array()){
		return array();
	}
	
	function loadAssocList($sql, $params = array()){
		return array();
	}
	
	function checkDriver($d){
		return false;
	}	
	
	function query($statement){
		return false;
	}
	
	function quote($v){
		return $v;
	}
	
	function exec($sql){
		return false;
	}
	
	function execute_query($sql, $params = array(), $driver_options = array()){
		return false;
	}
	
	function lastInsertId(){
		return null;
	}
	
	function split_sql($sql){
		return array($sql);
	}
}