<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\A\E\Chronoforms\L;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Models extends \G3\L\Component{
	// var $_models = [
	// 	'\G3\A\E\Chronoforms\M\Model'
	// ];

	var $models = [];
	var $log = [];
	var $dataset = [];

	function list(){
		if(empty($this->models)){
			$this->models = $this->Model->order(['id' => 'asc'])->where('enabled', 1)->select('all');
			
			return $this->models;
		}else{
			return $this->models;
		}
	}

	function tables($extdb = []){
		$dbo = \G3\L\Database::getInstance($extdb);
		if(empty($dbo->connected)){
			return [];
		}
		$db_tables = $dbo->getTablesList();

		$tables = [];
		foreach($db_tables as $k => $db_table){
			$db_table = str_replace(\G3\L\Config::get('db.prefix'), '#__', $db_table);
			$tables[$db_table] = $db_table;
		}

		return $tables;
	}

	function model($settings){
		$read = [
			'Model' => [
				'name' => 'Table',
				'params' => ['table' => $settings['name']]
			]
		];
		if(!empty($settings['vname'])){
			$read['Model']['name'] = $settings['vname'];
		}

		if(!empty($settings['dbo'])){
			$read['Model']['dbo'] = $settings['dbo'];
		}
		
		return $read;
	}

	function keys($settings){
		$list = [];
		if(!empty($settings['name'])){
			$model = $this->model($settings['name']);
			$list[] = $model['Model']['name'];
			if(!empty($model['Model']['params']['relations'])){
				foreach($model['Model']['params']['relations'] as $relation){
					$list[] = $relation['model'];
				}
			}
		}
		return $list;
	}

	function getModel($model){
		// $db_options = \G3\Globals::get('custom_db_options', []);
		// if(!empty($function['db']['enabled'])){
		// 	$db_options = $function['db'];
		// }
		$dbo = \G3\L\Database::getInstance();
		if(!empty($model['Model']['dbo'])){
			$dbo = \G3\L\Database::getInstance($model['Model']['dbo']);
		}
		$Model = new \G3\L\Model(['name' => $model['Model']['name'], 'table' => $model['Model']['params']['table'], 'dbo' => $dbo]);
		
		$this->log = $Model->dbo->log;
		
		return $Model;
	}

	function save($settings){
		$result = false;
		if(!empty($settings['name'])){
			
			$model = $this->model($settings);
			
			if(!empty($model['Model']['params']['table'])){
				$Model = $this->getModel($model);

				$nsettings = array_replace($model['Model']['params'], $settings);
				
				$action = $nsettings['action'] ?? 'insert';

				if(!empty($nsettings['conditions'])){
					$action = 'update';

					foreach($nsettings['conditions'] as $condition){
						if(!empty($condition['start'])){
							$Model->where('(');
						}

						if(is_array($condition['value'])){
							$value = [];
							foreach($condition['value'] as $cval){
								$value = array_merge($value, (array)$this->controller->Parser->parse($cval));
							}
						}else{
							$value = $this->controller->Parser->parse($condition['value']);
						}
						$Model->where($condition['field'], $value, $condition['op'] ?? '=');

						if(!empty($condition['end'])){
							$Model->where(')');
						}

						if(!empty($condition['logic'])){
							$Model->where($condition['logic']);
						}
					}
				}else if(!empty($nsettings['where'])){
					$Model->whereGroup($nsettings['where']);
				}else{
					if($action == 'update'){
						$action = 'insert:update';
					}
				}

				$save_settings = [];
				if($action == 'insert:update'){
					$save_settings['duplicate_update'] = true;
					$action = 'insert';
				}
				if($action == 'insert:ignore'){
					$save_settings['ignore'] = true;
					$action = 'insert';
				}

				// if(empty($nsettings['multiple']) AND !empty($this->data($model['Model']['name'].'.'.$Model->pkey))){
				// 	$action = 'update';
				// 	$Model->where($model['Model']['name'].'.'.$Model->pkey, $this->data($model['Model']['name'].'.'.$Model->pkey));
				// }

				$dataSet = [];

				if(!empty($nsettings['sets'])){
					foreach($nsettings['sets'] as $set){
						$dataSet = array_merge($dataSet, $this->controller->Parser->parse($set));
					}
				}

				if(!empty($nsettings['sources'])){
					foreach($nsettings['sources'] as $source){
						if(!empty($source['field'])){
							$source['field'] = $this->controller->Parser->parse($source['field']);
							if(is_array($source['field'])){
								$dataSet = array_merge($dataSet, $source['field']);
							}else{
								if(strpos($source['field'], '.') !== false){
									$source['field'] = explode('.', $source['field'])[1];
								}
								if(empty($source['fn'])){
									if(empty($source['op']) OR $source['op'] == $action){
										$dataSet[$source['field']] = $this->controller->Parser->parse($source['value']);
									}
								}else if($source['fn'] == 'datetime'){
									if(empty($source['op']) OR $source['op'] == $action){
										$dataSet[$source['field']] = $this->controller->Parser->parse('{date:Y-m-d H:i:s}');
									}
								}else if($source['fn'] == 'user_id'){
									if(empty($source['op']) OR $source['op'] == $action){
										$dataSet[$source['field']] = $this->controller->Parser->parse('{user:id}');
									}
								}else if($source['fn'] == 'json'){
									$dataSet[$source['field']] = json_encode($this->controller->Parser->parse($source['value']), JSON_UNESCAPED_UNICODE);
								}else{
									$dataSet[$source['field']] = $this->controller->Parser->parse($source['value']);
								}
							}
						}
					}
				}else{
					if(empty($dataSet) AND !is_null($this->data($model['Model']['name']))){
						$dataSet = $this->data($model['Model']['name'], []);
					}
				}

				foreach($dataSet as $field => $fdata){
					if(is_array($fdata)){
						$dataSet[$field] = json_encode($fdata, JSON_UNESCAPED_UNICODE);
					}
				}

				$this->dataset = $dataSet;
				
				$result = $Model->$action($dataSet, $save_settings);

				if(!empty($result)){
					$result = $Model->data;
				}

				$this->log = array_values(array_diff($Model->dbo->log, $this->log));
			}
		}
		return $result;
	}

	function delete($settings){
		$result = false;

		if(!empty($settings['name'])){
			
			$model = $this->model($settings);
			
			$vmodels = [];

			if(!empty($model['Model']['params']['table'])){
				
				$Model = $Model = $this->getModel($model);
				$vmodels[$model['Model']['name']] = &$Model;
				$start_dbo_log = $Model->dbo->log;

				$fields = [$model['Model']['name'].'.*'];
				$Model->fields($fields);

				$nsettings = array_replace($model['Model']['params'], $settings);

				if(!empty($nsettings['conditions'])){
					foreach($nsettings['conditions'] as $condition){
						if(!empty($condition['start'])){
							$Model->where('(');
						}

						if(is_array($condition['value'])){
							$value = [];
							foreach($condition['value'] as $cval){
								$value = array_merge($value, (array)$this->controller->Parser->parse($cval));
							}
						}else{
							$value = $this->controller->Parser->parse($condition['value']);
						}
						$Model->where($condition['field'], $value, $condition['op'] ?? '=');

						if(!empty($condition['end'])){
							$Model->where(')');
						}

						if(!empty($condition['logic'])){
							$Model->where($condition['logic']);
						}
					}

					$result = $Model->delete();
				}else if(!empty($nsettings['where'])){
					$Model->whereGroup($nsettings['where']);
				}

				$this->log = array_values(array_diff($Model->dbo->log, $this->log));
			}
		}
		return $result;
	}

	function read($settings){
		static $results = [];

		$md5 = md5(json_encode($settings));

		if(!empty($results[$md5])){
			return $results[$md5];
		}else{
			if(!empty($settings['name'])){
			
				$model = $this->model($settings);

				$vmodels = [];

				if(!empty($model['Model']['params']['table'])){

					$Model = $this->getModel($model);

					$vmodels[$model['Model']['name']] = &$Model;
					$start_dbo_log = $Model->dbo->log;

					$fields = [$model['Model']['name'].'.*'];
					
					$nsettings = array_replace($model['Model']['params'], $settings);

					if(!empty($nsettings['relations'])){
						foreach($nsettings['relations'] as $relation){
							if(!empty($relation['model']) AND !empty($relation['table'])){
								$relation_conditions = [];
								$relation_settings = [];
								
								$new_model = new \G3\L\Model(['name' => $relation['model'], 'table' => $relation['table']]);
								$vmodels[$relation['model']] = &$new_model;

								$relation_type = $relation['relation'];

								$target_model = !empty($relation['related_to']) ? $vmodels[$relation['related_to']] : $Model;

								if($relation['relation'] == 'hasMany'){
									$first_condition = array_shift($relation['rconditions']);
									$relation['fkey'] = $first_condition['field'];
									$relation['pkey'] = $first_condition['value'];
									$fields[] = $relation['model'].'.*';
								}else{
									$fields[] = $relation['model'].'.*';
								}

								foreach($relation['rconditions'] as $k => $rcondition){
									if(!empty($rcondition['start'])){
										$relation_conditions[] = '(';
									}
									if(!empty($rcondition['field']) AND !empty($rcondition['value'])){
										$relation_conditions[] = [
											$rcondition['field'], 
											$rcondition['value'], 
											$rcondition['op'], 
											$rcondition['value_type']
										];
									}
									if(!empty($rcondition['end'])){
										$relation_conditions[] = ')';
									}
									if(!empty($rcondition['logic'])){
										$relation_conditions[] = $rcondition['logic'];
									}
								}

								if($relation['relation'] == 'hasMany' AND !empty($relation_conditions)){
									foreach($relation_conditions as $rk => $relation_condition){
										if(is_array($relation_condition)){
											$relation_conditions[$rk][3] = 'value';
										}
									}
									$new_model->whereGroup($relation_conditions);
								}

								if(!empty($relation['fkey'])){
									$relation_conditions = $relation['fkey'];
								}
								
								if(!empty($relation['pkey'])){
									$relation_settings['pkey'] = $relation['pkey'];
								}

								if($relation == 'subqueryJoin'){
									$joinQ = $new_model->returnQuery('select');
									$target_model->join($joinQ, $relation['model'], $relation_conditions);
								}else{
									$target_model->$relation_type($new_model, $relation['model'], $relation_conditions, $relation_settings);
								}
							}
						}
					}

					if(!empty($nsettings['conditions'])){
						foreach($nsettings['conditions'] as $condition){
							if(!empty($condition['start'])){
								$Model->where('(');
							}

							if(is_array($condition['value'])){
								$value = [];
								foreach($condition['value'] as $cval){
									$value = array_merge($value, (array)$this->controller->Parser->parse($cval));
								}
							}else{
								$value = $this->controller->Parser->parse($condition['value']);
							}
							$Model->where($condition['field'], $value, $condition['op'] ?? '=');

							if(!empty($condition['end'])){
								$Model->where(')');
							}

							if(!empty($condition['logic'])){
								$Model->where($condition['logic']);
							}
						}
					}else if(!empty($nsettings['where'])){
						$Model->whereGroup($nsettings['where']);
					}else{
						if(!empty($nsettings['select']) AND $nsettings['select'] == 'first'){
							if(!is_null($this->data($Model->pkey))){
								$Model->where($model['Model']['name'].'.'.$Model->pkey, $this->data($Model->pkey));
							}else{
								$Model->limit(1);
							}
						}
					}

					if(!empty($nsettings['order'])){
						foreach($nsettings['order'] as $order){
							if(!empty($order['field'])){
								$Model->order([$order['field'] => $order['direction']]);
							}
						}
					}

					if(!empty($nsettings['search'])){
						foreach($nsettings['search'] as $search){
							if(!empty($search['fields'])){
								$this->controller->Search($Model, $search['fields'], $search['fieldname']);
							}
						}
					}

					if(!empty($nsettings['filters'])){
						foreach($nsettings['filters'] as $filter){
							if(!empty($this->data($filter['fieldname'])) OR $this->data($filter['fieldname']) == '0'){
								$Model->where($filter['field'], $this->data($filter['fieldname']));
							}
						}
					}

					//paginate
					if(!empty($nsettings['paging'])){
						$this->controller->Paginate($Model, $Model->alias, ($nsettings['limit'] ?? 0));
					}else{
						if(!empty($nsettings['limit'])){
							$Model->limit($this->controller->Parser->parse($nsettings['limit']));
						}
			
						if(!empty($nsettings['offset'])){
							$Model->offset($this->controller->Parser->parse($nsettings['offset']));
						}
					}

					if(!empty($nsettings['fields'])){
						foreach($nsettings['fields'] as $field){
							if(!empty($field['field']) AND !empty($field['alias'])){
								$Model->fields([$field['field'] => $field['alias']]);
							}
						}
					}
					$Model->fields($fields);

					if(!empty($nsettings['group'])){
						foreach($nsettings['group'] as $field){
							$Model->group([$field['field']]);
						}
					}

					if(!empty($nsettings['sortable'])){
						$this->controller->Order($Model, $nsettings['sortable']);
					}

					$select_settings = [];
					if(!empty($nsettings['specials'])){
						foreach($nsettings['specials'] as $special){
							if(!empty($special['field'])){
								if($special['type'] == 'json'){
									$select_settings['json'][] = $special['field'];
								}
							}
						}
					}

					$results[$md5] = $Model->select($nsettings['select'] ?? 'all', $select_settings);
					
					$this->log = array_values(array_diff($Model->dbo->log, $this->log));
				}
			}

			return $results[$md5] ?? [];
		}
	}

}