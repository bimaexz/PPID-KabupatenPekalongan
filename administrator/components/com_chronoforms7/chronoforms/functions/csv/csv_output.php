<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$action = $function['action'];
	$file_path = $this->Parser->parse($function['file_path']);
	$delimiter = $function['delimiter'];
	
	// $data = $this->Parser->parse($function['data_provider']);
	$results = [];
	if(!empty($function['data_source'])){
		$results = $this->controller->FData->dsources($function['data_source']);
	}
	
	if(!empty($action) AND !empty($results)){
		$columns = [];
		if(!empty($function['columns'])){
			foreach($function['columns'] as $column){
				$columns[$column['path']] = $column['title'];
			}
		}else{
			$columns = array_combine(array_keys(array_values($results)[0]), array_keys(array_values($results)[0]));
		}
		
		$titles = array_values($columns);

		$lines = [];
		$lines[] = $titles;
		
		if(!empty($function['disable_titles'])){
			$lines = [];
		}

		if(!empty($results)){
			foreach($results as $k => $row){
				$line = [];
				foreach($columns as $cpath => $ctitle){
					$line[] = \G3\L\Arr::getVal($row, $cpath, '');
				}
				$lines[] = $line;
			}
		}

		$saved = false;

		\G3\L\Csv::build($lines, $delimiter, $action, $file_path, $saved);

		$this->set($function['name'].'.file', ['path' => $file_path]);
		$this->set($function['name'].'.saved', $saved);
		$this->set($function['name'].'.data', $lines);

	}