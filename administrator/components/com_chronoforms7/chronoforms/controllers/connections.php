<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\E\Chronoforms\C;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Connections extends \G3\A\E\Chronoforms\App {
	use \G3\A\C\T\DataOps;

	var $_libs = array(
		'FData' => '\G3\A\E\Chronoforms\L\Fdata',
		'Parser' => '\G3\A\E\Chronoforms\H\Parser2',
		'Behaviors' => '\G3\A\E\Chronoforms\L\Behaviors',
		// 'Locales' => '\G3\A\E\Chronoforms\L\Locales',
		'Acls' => '\G3\A\E\Chronoforms\L\Acls',
		'Models' => '\G3\A\E\Chronoforms\L\Models',
	);
	
	var $_models = array(
		'\G3\A\E\Chronoforms\M\Connection', 
	);
	
	var $_helpers = array(
		//'Html' => '\G3\H\Html',
		'Field' => '\G3\A\E\Chronoforms\H\Field',
		'Parser' => '\G3\A\E\Chronoforms\H\Parser2',
	);

	// function _initialize(){
	// 	parent::_initialize();
	// 	if(true or empty($this->get('cf_settings.email', []))){
	// 		\GApp3::message('error', rl3('Your Global Email settings are not set, please check and save the ChronoForms7 Global Settings!'));

	// 		$this->redirect(r3('index.php?ext=chronoforms&act=settings'));
	// 	}
	// }
	
	function index(){
		$json_fields = ['settings', 'functions'];

		if(!empty($this->data('pversion'))){
			$dbo = \G3\L\Database::getInstance();
			$db_tables = $dbo->getTablesList();

			if($this->data('pversion') == 'cf5' AND $dbo->tableExists('#__chronoengine_chronoforms')){
				$Table = new \G3\L\Model(['name' => 'Connection', 'table' => '#__chronoengine_chronoforms', 'dbo' => $dbo]);

				$this->Connection = $Table;

				$json_fields = ['params'];
			}
		}else{
			//search
			$this->Search($this->Connection, ['title', 'alias', 'description']);
			if(!empty($this->data('tagged'))){
				$this->Connection->where('settings', '%"tags":[%"'.$this->data('tagged').'"%]%', 'LIKE');
			}
		}
		//paginate
		$this->Paginate($this->Connection);
		$this->_helpers['Paginator']['settings']['info']['lang'] = rl3('Viewing %s forms, %s through %s of %s total', ['%s', '%s', '%s', '%s']);
		//sort
		$this->Order($this->Connection, ['Connection.title', 'Connection.id', 'Connection.published']);
		
		$connections = $this->Connection->select('all', ['json' => $json_fields]);

		if($this->data('pversion') == 'cf5'){
			foreach($connections as $kc => $connection){
				$connections[$kc]['Connection'] = \G3\A\E\Chronoforms\L\Converter::cf5($connections[$kc]);
			}

			$this->view = 'index_legacy';
		}

		$this->set('connections', $connections);
	}

	function wizard(){
		
	}

	function install($connection = null){
		if(empty($connection)){
			$connection = $this->Connection->where('id', $this->data('id'))->select('first', ['json' => ['settings', 'pgroups', 'pages', 'views', 'functions']]);
		}

		if(!empty($connection['Connection']['settings']['form']['installer'])){
			if(!empty($connection['Connection']['settings']['form']['installer']['db_tables'])){

				// pr($connection['Connection']['settings']['form']['installer']['db_tables']);
				$dbo = \G3\L\Database::getInstance();
				$db_tables = $dbo->getTablesList();

				foreach($db_tables as $k => $db_table){
					$db_tables[] = str_replace(\G3\L\Config::get('db.prefix'), '#__', $db_table);
				}
				
				foreach($connection['Connection']['settings']['form']['installer']['db_tables'] as $dtk => $table){
					if(!in_array($table['name'], $db_tables)){
						$rows = [];
						$field = array_values($table['fields'])[0];
						$rows[] = '`'.$field['name'].'` '.$field['type'].'';
						
						// $rows[] = 'PRIMARY KEY (`aid`)';
						$rows = array('CREATE TABLE IF NOT EXISTS `'.$table['name'].'` (', implode(",\n", $rows));
						$rows[] = ') DEFAULT CHARSET=utf8;';
						$sql = implode("\n", $rows);
						$sql = $dbo->_prefixTable($sql);
						// pr($sql);die();
						$dbo->exec($sql);
						
						// $this->data['Connection']['models'][$km]['db_table'] = $table['name'];
						
					}else{
						// $table['name'] = $model['db_table'];
						// $table['name'] = $dbo->_prefixTable($table['name']);
					}
					
					$Table = new \G3\L\Model(['name' => 'Table', 'table' => $table['name'], 'dbo' => $dbo]);
					//refresh the table fields
					$Table->tablefields(true);
					
					if(!empty($table['fields'])){
						foreach($table['fields'] as $field){
							if(!in_array($field['name'], $Table->tablefields)){
								$Table->addField($field['name'], $field);
							}else{
								if(!empty($field['key'])){
									$Table->keyField($field['name'], $field['key']);
								}
								$Table->alterField($field['name'], $field['name'], $field);
							}
						}
					}
					
					//refresh the table fields
					$Table->tablefields(true);
					
				}
				
			}
		}
	}

	function edit_legacy(){
		if(!empty($this->data('pversion')) AND !empty($this->data('pid'))){
			$dbo = \G3\L\Database::getInstance();
			$db_tables = $dbo->getTablesList();

			if($this->data('pversion') == 'cf5'){
				$Table = new \G3\L\Model(['name' => 'Connection', 'table' => '#__chronoengine_chronoforms', 'dbo' => $dbo]);

				$this->Connection = $Table;

				$json_fields = ['params'];
			}

			$connection = $this->Connection->where('id', $this->data('pid', null))->select('first', ['json' => $json_fields]);

			if(!empty($connection)){
				if($this->data('pversion') == 'cf5'){
					$connection['Connection'] = \G3\A\E\Chronoforms\L\Converter::cf5($connection, ['id' => '']);
				}

				$this->data = array_merge($this->data, $connection);
			}
			
			$this->set('connection', $connection);
		}

		$this->set('cf_settings.formeditor.safe_mode', false);

		$this->view = 'edit';
	}
	
	function edit(){
		if(isset($this->data['save']) OR isset($this->data['apply'])){
			$result = false;
			
			$this->DataOps()->chunk('_formchunks');
			// pr($this->data);die();
			if(!empty($this->get('cf_settings.formeditor.safe_mode', true)) AND !empty($this->data('Connection.id'))){
				
				$connection = $this->Connection->where('id', $this->data('Connection.id'))->select('first', ['json' => ['settings', 'pgroups', 'pages', 'views', 'functions']]);
				if(!empty($connection)){
					foreach($this->data('Connection.views', []) as $uid => $unit){
						if(empty($unit['type'])){
							$this->data['Connection']['views'][$uid] = array_replace($connection['Connection']['views'][$uid], $this->data['Connection']['views'][$uid]);
						}
					}

					foreach($this->data('Connection.functions', []) as $uid => $unit){
						if(empty($unit['type'])){
							$this->data['Connection']['functions'][$uid] = array_replace($connection['Connection']['functions'][$uid], $this->data['Connection']['functions'][$uid]);
						}
					}
				}
			}

			$form_settings = $this->data('Connection.settings.form', []);
			
			if(in_array('log_table', $form_settings['behaviors']['data'] ?? [])){
				$dbo = \G3\L\Database::getInstance();
				$db_tables = $dbo->getTablesList();
				
				if(empty($form_settings['log_table']['tablename']) OR !$dbo->tableExists($form_settings['log_table']['tablename'])){
					$tablename = strtolower('#__chronoforms7_logtable_'.\G3\L\Str::slug($this->data('Connection.title'), '_', true));
					
					// $defaults = [
					// 	'user_id' => '`user_id` int(11) NOT NULL',
					// 	'created' => "`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",
					// 	'modified' => '`modified` datetime DEFAULT NULL',
					// ];

					$sqls = [];
					$sqls[] = '`aid` int(11) NOT NULL AUTO_INCREMENT';
					
					$sqls[] = 'PRIMARY KEY (`aid`)';
					$sqls = array('CREATE TABLE IF NOT EXISTS `'.$tablename.'` (', implode(",\n", $sqls));
					$sqls[] = ') DEFAULT CHARSET=utf8;';
					
					$sql = implode("\n", $sqls);

					$sql = $dbo->_prefixTable($sql);
					$dbo->exec($sql);

					$this->data['Connection']['settings']['form']['log_table']['tablename'] = $tablename;
				}
				
				$tablename = $form_settings['log_table']['tablename'];
				$Table = new \G3\L\Model(['name' => 'Table', 'table' => $tablename, 'dbo' => $dbo]);
				//refresh the table fields
				$Table->tablefields(true);

				$defaults = [
					'uid' => ['type' => 'varchar', 'length' => 100],
					'user_id' => ['type' => 'int', 'length' => 11],
					'created' => ['type' => 'datetime', 'default' => '0000-00-00 00:00:00'],
					'modified' => ['type' => 'datetime', 'default' => 'NULL'],
					'ipaddress' => ['type' => 'varchar', 'length' => 30],
					'page' => ['type' => 'varchar', 'length' => 50],
				];

				if(!empty($form_settings['log_table']['defaults'])){
					foreach($form_settings['log_table']['defaults'] as $default){
						if(!in_array($default, $Table->tablefields)){
							$Table->addField($default, $defaults[$default]);
						}
					}
				}

				$Table->tablefields(true);

				$types = [
					'field_textarea' => ['type' => 'text'],
					'wfield_signature' => ['type' => 'text'],
				];

				foreach($this->data('Connection.views', []) as $unit){
					if(!empty($unit['behaviors']['data']) AND in_array('field_dbtable', $unit['behaviors']['data'])){
						if(!empty($unit['nodes']['main']['attrs']['name'])){
							if(!in_array('u_'.$unit['uid'], $Table->tablefields)){
								if(!empty($types[$unit['type']])){
									$Table->addField('u_'.$unit['uid'], $types[$unit['type']]);
								}else{
									$Table->addField('u_'.$unit['uid'], ['type' => 'varchar', 'length' => 255]);
								}
							}
						}
					}
				}
				
				//refresh the table fields
				$Table->tablefields(true);
			}
			// pr($this->data);die();


			// if(!empty($this->data('Connection.title')) AND !empty($this->data['Connection']['models'])){
			// 	$dbo = \G3\L\Database::getInstance();
			// 	$db_tables = $dbo->getTablesList();
			// 	$view = new \G3\L\View($this);
			// 	$parser = new \G3\A\E\Chronoforms\H\Parser($view);
				
			// 	$form_fields = [];
			// 	$long_fields = [];
			// 	if(!empty($this->data('Connection.views'))){
			// 		foreach($this->data('Connection.views') as $view){
			// 			if(!empty($view['settings']['name']) AND !empty($view['dynamics']['save']['enabled'])){
			// 				$fname = $parser->dpath($view['settings']['name']);
							
			// 				$form_fields[$view['name']] = $parser->lname($fname);
							
			// 				if($view['type'] == 'field_textarea' OR strpos($view['settings']['name'], '[]') !== false){
			// 					$long_fields[] = $form_fields[$view['name']];
			// 				}
			// 			}
			// 		}
			// 	}
				
			// 	foreach($this->data['Connection']['models'] as $km => $model){
			// 		if(!empty($model['enabled'])){
			// 			if(1){
			// 				if(empty($model['db_table'])){
			// 					$tablename = strtolower('#__chronoforms_data_'.\G3\L\Str::slug($this->data('Connection.title'), '_', true).'_'.$model['name']);
			// 				}else{
			// 					$tablename = $model['db_table'];
			// 				}
			// 				//$tablename = $dbo->_prefixTable($tablename);
							
			// 				if(!in_array($tablename, $db_tables)){
			// 					$rows = [];
			// 					$rows[] = '`aid` int(11) NOT NULL AUTO_INCREMENT';
								
			// 					if(empty($model['layout'])){
			// 						$rows[] = '`user_id` int(11) NOT NULL';
			// 						$rows[] = "`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'";
			// 						$rows[] = '`modified` datetime DEFAULT NULL';
			// 					}else if($model['layout'] == 'custom'){
									
			// 					}
								
			// 					$rows[] = 'PRIMARY KEY (`aid`)';
			// 					$rows = array('CREATE TABLE IF NOT EXISTS `'.$tablename.'` (', implode(",\n", $rows));
			// 					$rows[] = ') DEFAULT CHARSET=utf8;';
			// 					$sql = implode("\n", $rows);
			// 					$sql = $dbo->_prefixTable($sql);
			// 					$dbo->exec($sql);
			// 				}
							
			// 				$this->data['Connection']['models'][$km]['db_table'] = $tablename;
							
			// 			}else{
			// 				$tablename = $model['db_table'];
			// 				$tablename = $dbo->_prefixTable($tablename);
			// 			}
						
			// 			$Table = new \G3\L\Model(['name' => 'Table', 'table' => $tablename, 'dbo' => $dbo]);
			// 			//refresh the table fields
			// 			$Table->tablefields(true);
						
			// 			if(!empty($model['fields'])){
			// 				foreach($model['fields'] as $field){
			// 					if(!in_array($field['name'], $Table->tablefields)){
			// 						$Table->addField($field['name'], $field);
			// 					}
			// 				}
			// 			}
						
			// 			//refresh the table fields
			// 			$Table->tablefields(true);
						
			// 			if(!empty($model['sync'])){
			// 				foreach($form_fields as $view_name => $fieldname){
			// 					if(!in_array($fieldname, $Table->tablefields)){
			// 						if(in_array($fieldname, $long_fields)){
			// 							$Table->addField($fieldname, ['type' => 'text']);
			// 						}else{
			// 							$Table->addField($fieldname, ['type' => 'varchar', 'length' => 255]);
			// 						}
			// 					}
			// 				}
			// 			}else{
			// 				if(!empty($model['fields'])){
			// 					$fields_names = \G3\L\Arr::getVal($model['fields'], '[n].name', []);
			// 					foreach($Table->tablefields as $fieldname){
			// 						if(!in_array($fieldname, $fields_names)){
			// 							$Table->dropField($fieldname);
			// 						}
			// 					}
			// 				}
			// 			}
						
			// 		}
			// 		//pr($this->data['Connection']['models']);die();
			// 	}
				
			// }

			if(!empty($this->data['Connection'])){
				$this->install($this->data);
			}
			
			if(!empty($this->data['Connection'])){
				if(!empty($this->data['Connection']['functions'])){
					foreach($this->data['Connection']['functions'] as $n => $function){
						if($function['type'] == 'generic'){
							$this->data['Connection']['functions'][$n] = json_decode($function['settings'], true);
						}
					}
				}

				if(!empty($this->data['Connection']['views'])){
					foreach($this->data['Connection']['views'] as $n => $view){
						if($view['type'] == 'generic'){
							$this->data['Connection']['views'][$n] = json_decode($view['settings'], true);
						}
					}
				}
				
				$this->data['Connection']['settings']['__lastsave'] = time();
				//$this->createTemplates();

				if(!isset($this->data['Connection']['description'])){
					$this->data['Connection']['description'] = '';
				}
				$result = $this->Connection->save($this->data['Connection'], ['validate' => true, 'json' => ['settings', 'pgroups', 'pages', 'views', 'functions'], 'alias' => ['title' => 'alias']]);
			}
			
			if($result === true){
				
				// if(!empty($this->Connection->id) AND !empty($this->data('Connection.settings.log.dedicated'))){
				// 	$dbo = \G3\L\Database::getInstance();
					
				// 	$form_fields = [];
				// 	if(!empty($this->data('Connection.views'))){
				// 		foreach($this->data('Connection.views') as $k => $view){
				// 			if(!empty($view['settings']['name']) AND $view['type'] != 'field_button'){
				// 				$fname = \G3\L\Html::dpath($view['settings']['name']);
								
				// 				$form_fields[$k] = ['name' => \G3\L\Html::lname($fname)];
								
				// 				if($view['type'] == 'field_textarea' OR strpos($view['settings']['name'], '[]') !== false){
				// 					$form_fields[$k]['type'] = 'text';
				// 				}else{
				// 					$form_fields[$k]['type'] = 'varchar';
				// 					$form_fields[$k]['length'] = 255;
				// 				}
				// 			}
				// 		}
						
				// 		if(!empty($form_fields)){
				// 			$tablename = '#__chronoforms_data_form_'.$this->Connection->id;
				// 			$dbo->createTable($tablename);
				// 			$Table = new \G3\L\Model(['name' => 'Table', 'table' => $tablename, 'dbo' => $dbo]);
				// 			$Table->syncFields($form_fields);
				// 		}
				// 	}
				// }
				
				if(isset($this->data['apply'])){
					$redirect = r3('index.php?ext=chronoforms&cont=connections&act=edit&id='.$this->Connection->id);
				}else{
					$redirect = r3('index.php?ext=chronoforms&cont=connections');
				}
				return ['success' => rl3('Form saved successfully.'), 'redirect' => $redirect];
			}else{
				
				$this->errors['Connection'] = $this->Connection->errors;
				unset($this->data['save']);
				unset($this->data['apply']);
				return ['error' => $this->Connection->errors, 'reload' => true];
			}
		}
		
		if(!empty($this->data['id'])){
			$connection = $this->Connection->where('id', $this->data('id', null))->select('first', ['json' => ['settings', 'pgroups', 'pages', 'views', 'functions']]);
			if(!empty($connection)){
				$this->data = array_merge($this->data, $connection);
			}
			// pr($this->data);
			$this->set('connection', $connection);
		}else{
			//default data
			if(empty($this->data['Connection'])){
				if($this->data('apptype') == 'contact'){
					$this->data['Connection']['apptype'] = 'contact';
					$this->data['Connection']['pages'] = [
						1 => ['name' => 'start_page', 'pgroup' => 1],
						2 => ['name' => 'end_page', 'pgroup' => 1],
					];
					$this->data['Connection']['pgroups'] = [
						1 => [
							'name' => 'contact',
						]
					];
					$this->data['Connection']['settings']['form']['behaviors']['data'] = [
						'admin_email',
						'confirmation_message',
						'check_security_fields',
						'upload_files',
						'validate_fields',
						'log_data',
					];
				}else if($this->data('apptype') == 'form'){
					$this->data['Connection']['apptype'] = 'form';
					$this->data['Connection']['pages'] = [
						1 => ['name' => 'start_page', 'pgroup' => 1],
						2 => ['name' => 'end_page', 'pgroup' => 1],
					];
					$this->data['Connection']['pgroups'] = [
						1 => [
							'name' => 'form',
						]
					];
					$this->data['Connection']['settings']['form']['behaviors']['data'] = [
						// 'admin_email',
						// 'confirmation_message',
						'check_security_fields',
						'upload_files',
						'validate_fields',
						// 'log_data',
					];
				}else if($this->data('apptype') == 'connectivity'){
					$this->data['Connection']['apptype'] = 'connectivity';
					$this->data['Connection']['pages'] = [
						'-connectivity-repo-page-' => ['name' => '-connectivity-repo-page-', 'pgroup' => '-connectivity-repo-pgroup-', 'description' => 'The repository page'],
						2 => ['name' => 'index', 'pgroup' => 2],
					];
					$this->data['Connection']['pgroups'] = [
						'-connectivity-repo-pgroup-' => [
							'name' => '-connectivity-repo-pgroup-',
							'type' => 'private',
						],
						2 => [
							'name' => 'connection',
						],
					];
					$this->data['Connection']['settings']['form']['behaviors']['data'] = [
						
					];
				}
			}
		}

		if(!empty($this->data('apptype'))){
			$this->data['Connection']['apptype'] = $this->data('apptype');
		}
		
		//load saved blocks
		// $Block = new \G3\A\E\Chronoforms\M\Block();
		// $blocks = $Block->fields(['id', 'title', 'type', 'group', 'desc', 'block_id'])->order(['title' => 'asc', 'group' => 'asc'])->where('published', 1)->select('all');
		// $blocks_views = [];
		// $blocks_functions = [];
		// foreach($blocks as $block){
		// 	$blk = [
		// 		'name' => 'block-'.$block['Block']['id'],
		// 		'title' => $block['Block']['title'],
		// 		'desc' => $block['Block']['desc'],
		// 		'group' => !empty($block['Block']['group']) ? $block['Block']['group'] : 'Default',
		// 	];
			
		// 	if($block['Block']['type'] == 'views'){
		// 		$blocks_views['block-'.$block['Block']['id']] = $blk;
		// 	}else{
		// 		$blocks_functions['block-'.$block['Block']['id']] = $blk;
		// 	}
		// }
		// $this->set('blocks', $blocks);
		// $this->set('blocks_views', $blocks_views);
		// $this->set('blocks_functions', $blocks_functions);

		$this->view = 'edit';

		// if($this->data['Connection']['apptype'] == 'connectivity'){
		// 	$this->view = 'edit_connectivity';
		// }
		
		// $db_tables = \G3\L\Database::getInstance()->getTablesList();
		// $db_tables2 = [];
		// foreach($db_tables as $dk => $db_table){
		// 	$db_tables2[str_replace(\G3\L\Config::get('db.prefix'), '#__', $db_table)] = $db_table;
		// }
		// $this->set('db_tables', $db_tables2);
		
		// if(!empty($this->data('Connection.models')) AND is_array($this->data('Connection.models'))){
		// 	foreach($this->data('Connection.models') as $kc => $model){
		// 		if(!empty($model['db_table']) AND in_array($model['db_table'], $db_tables2)){
		// 			$Table = new \G3\L\Model(['name' => 'Table', 'table' => $model['db_table']]);
		// 			$fields = $Table->dbo->getTableInfo($model['db_table']);
					
		// 			$table_fields = [1];
		// 			foreach($fields as $field){
		// 				$types = explode('(', $field['Type']);
		// 				$table_fields[] = [
		// 					'name' => $field['Field'],
		// 					'default' => $field['Default'],
		// 					'type' => $types[0],
		// 					'length' => !empty($types[1]) ? rtrim($types[1], ')') : '',
		// 				];
		// 			}
					
		// 			$this->data['Connection']['models'][$kc]['fields'] = $table_fields;
		// 		}
		// 	}
		// 	//pr($this->data['Connection']['models']);
		// }
	}
	
	function toggle(){
		return $this->toggleRecord($this->Connection);
	}
	
	function delete(){
		return $this->deleteRecord($this->Connection);
	}
	
	function copy(){
		if(is_array($this->data('gcb'))){
			
			$results = $this->Connection->where('id', $this->data('gcb'), 'in')->select();
			
			foreach($results as $result){
				unset($result['Connection']['id']);
				$result['Connection']['title'] = $result['Connection']['title'].' Copy @'.date('Ymd-His');
				$result['Connection']['alias'] = $result['Connection']['alias'].'-copy-'.date('Ymd-His');
				$this->Connection->save($result['Connection']);
			}
		}
		
		$this->redirect(r3('index.php?ext=chronoforms&cont=connections'));
	}
	
	function backup(){
		
		if(is_array($this->data('gcb'))){
			
			$results = $this->Connection->where('id', $this->data('gcb'), 'in')->select();
			$output = json_encode($results);
			
			$name = 'Chronoforms7_'.\G3\L\Url::domain();
			if(count($results) == 1){
				$name = $results[0]['Connection']['title'];
			}
			
			//download the file
			if(preg_match('Opera(/| )([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])){
				$UserBrowser = 'Opera';
			}elseif(preg_match('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])){
				$UserBrowser = 'IE';
			}else{
				$UserBrowser = '';
			}
			$mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
			@ob_end_clean();
			ob_start();

			header('Content-Type: ' . $mime_type);
			header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');

			if ($UserBrowser == 'IE') {
				header('Content-Disposition: inline; filename="' . $name.'_'.date('d_M_Y_H:i:s').'.cf7bak"');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
			}
			else {
				header('Content-Disposition: attachment; filename="' . $name.'_'.date('d_M_Y_H:i:s').'.cf7bak"');
				header('Pragma: no-cache');
			}
			print $output;
			exit();
		}
		
		$this->redirect(r3('index.php?ext=chronoforms&cont=connections'));
	}
	
	function restore(){
		if(!empty($_FILES)){
			$file = $_FILES['backup'];
			
			if(!empty($file['size'])){
				
				$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
				
				if($ext != 'cf7bak' AND $ext != 'cf5bak'){
					\GApp3::session()->flash('error', rl3('Invalid backup file extension.'));
					$this->redirect(r3('index.php?ext=chronoforms&cont=connections'));
				}
				
				$target = \G3\Globals::get('CACHE_PATH').$file['name'];
				
				$saved = \G3\L\Upload::save($file['tmp_name'], $target);
				
				if(!$saved){
					\GApp3::session()->flash('error', l_('Upload error'));
				}else{
					if($ext == 'cf7bak'){
						$data = file_get_contents($target);
						\G3\L\File::delete($target);
						
						$rows = json_decode($data, true);
						//pr($rows);die();
						if(!empty($rows)){
							foreach($rows as $row){
								if(isset($row['Connection']['id'])){
									$row['Connection']['id'] = null;
									$row['Connection']['published'] = 0;
									$this->Connection->save($row['Connection']);
								}
							}
						}
					}else if($ext == 'cf5bak'){
						$data = file_get_contents($target);
						$forms = unserialize(base64_decode(trim($data)));
						
						if(!empty($forms)){
							foreach($forms as $form){
								// pr($form);
								$connection['Connection'] = \G3\A\E\Chronoforms\L\Converter::cf5(['Connection' => $form['Form']], ['id' => '']);
								// pr($connection['Connection']);
								$this->Connection->save($connection['Connection'], ['validate' => true, 'json' => ['settings', 'pgroups', 'pages', 'views', 'functions'], 'alias' => ['title' => 'alias']]);
							}
						}
						// die();
					}
					
					\GApp3::session()->flash('success', rl3('Forms restored successfully.'));
					if(!empty($rows)){
						foreach($rows as $row){
							\GApp3::session()->flash('info', rl3('"%s" has been restored', [$row['Connection']['title']]));
						}
					}
					$this->redirect(r3('index.php?ext=chronoforms&cont=connections'));
				}
			}
		}
	}
	
	function demoslist(){
		
	}
	
	function demos(){
		if($this->data('name')){
			$demo_path = \G3\Globals::ext_path('chronoforms', 'admin').'demos'.DS.$this->data('name').'.cf7bak';
			$data = file_get_contents($demo_path);
			
			$rows = json_decode($data, true);
			
			$rows[0]['Connection']['id'] = null;
			$rows[0]['Connection']['title'] .= ' '.time();
			$rows[0]['Connection']['alias'] = null;
			
			$rows[0]['Connection']['pages'] = json_decode($rows[0]['Connection']['pages'], true);
			$rows[0]['Connection']['pgroups'] = json_decode($rows[0]['Connection']['pgroups'], true);
			$rows[0]['Connection']['views'] = json_decode($rows[0]['Connection']['views'], true);
			$rows[0]['Connection']['functions'] = json_decode($rows[0]['Connection']['functions'], true);
			$rows[0]['Connection']['settings'] = json_decode($rows[0]['Connection']['settings'], true);
			
			$this->data['Connection'] = $rows[0]['Connection'];
		}
		
		$this->edit();
	}
	
	function table(){
		if(is_array($this->data('gcb'))){
			$connection = $this->Connection->where('id', $this->data['gcb'][0])->select('first');
			$table = '#__chronoforms_data_'.$connection['Connection']['alias'];
			$this->redirect(r3('index.php?ext=chronoforms&cont=tables&act=build&gcb[]='.$connection['Connection']['id'].'&table_name='.$this->Connection->dbo->_prefixTable($table)));
			
		}
		\GApp3::session()->flash('error', rl3('Please select a form.'));
		$this->redirect(r3('index.php?ext=chronoforms&cont=connections'));
	}
	
	function clear_cache(){
		$this->redirect(r3('index.php?ext=chronoforms&act=clear_cache'));
	}

	function get_forms_list(){
		return $this->Connection->where('published', 1)->select('all', ['json' => ['pgroups', 'pages']]);
	}

	function get_connection_data($path = ''){
		if(!empty($this->data('Connection.id'))){
			$connection = $this->Connection->where('id', $this->data('Connection.id'))->select('first', ['json' => ['settings', 'pgroups', 'pages', 'views', 'functions']]);
			
			if(!empty($connection)){
				if(!empty($path)){
					return \G3\L\Arr::getVal($connection, $path);
				}else{
					return $connection;
				}
			}else{
				return [];
			}
		}
	}

	function behavior_config(){
		$this->set('utype', $this->data('utype'));
		$this->set('n', $this->data('count'));
		
		$file_path = \G3\Globals::ext_path('chronoforms', 'admin').$this->data('utype').DS.$this->data('type').DS.'behaviors'.DS.$this->data('behavior').DS.$this->data('behavior').'.php';

		if(file_exists($file_path)){
			$behavior = require_once($file_path);
		}else{
			$behavior = require_once(\G3\Globals::ext_path('chronoforms', 'admin').'behaviors'.DS.$this->data('utype').DS.$this->data('behavior').DS.$this->data('behavior').'.php');
		}

		$this->set('behavior', $behavior);

		if(!empty($this->data['Connection'][$this->data('utype')][$this->data('count')])){
			$this->set('unit', $this->data['Connection'][$this->data('utype')][$this->data('count')]);
			
			// $unit_info = require_once(\G3\Globals::ext_path('chronoforms', 'admin').$this->data('utype').DS.$this->data('type').DS.$this->data('type').'.php');
			// $this->set('unit.info', $unit_info);
		}else{
			$this->set('unit', ['utype' => $this->data('utype'), 'type' => $this->data('type')]);
		}

		// if(!empty($this->data('Connection.id'))){
		// 	$connection = $this->Connection->where('id', $this->data('Connection.id'))->select('first', ['json' => ['settings', 'pgroups', 'pages', 'views', 'functions']]);
			
		// 	if(!empty($connection)){
		// 		$this->data['Connection'] = $connection['Connection'];
		// 	}
		// }
	}

	function unit_load(){
		$uid = $this->data('uid');

		$connection = $this->Connection->where('id', $this->data('Connection.id'))->select('first', ['json' => ['settings', 'pgroups', 'pages', 'views', 'functions']]);
		
		if(!empty($connection)){
			$this->data['Connection'] = $connection['Connection'];

			$unit = $connection['Connection'][$this->data('utype')][$uid];
			$this->set('utype', $unit['utype']);
			$this->set('type', $unit['type']);
			$this->set('count', $unit['uid']);
			
			$this->set('unit', $unit);

			$this->view = 'units_config_area';
		}
	}
	
	function unit_config(){
		$this->set('type', $this->data('type'));
		$this->set('count', $this->data('count'));

		$this->set('utype', $this->data('utype'));
		$this->set('unit', ['name' => $this->data('type').'_'.$this->data('count'), 'type' => $this->data('type'), 'utype' => $this->data('utype'), 'uid' => $this->data('count')]);
		
		$this->view = 'units_config';
		
		
		// $Block = new \G3\A\E\Chronoforms\M\Block();
		// $blocks = $Block->fields(['id', 'title', 'type', 'group', 'desc', 'block_id'])->order(['title' => 'asc', 'group' => 'asc'])->where('published', 1)->select('all');
		// $this->set('blocks', $blocks);
		
		//blocks support
		if(false AND strpos($this->data('type'), 'block-') === 0){
			$Block = new \G3\A\E\Chronoforms\M\Block();
			$blockData = $Block->where('id', str_replace('block-', '', $this->data('type')))->select('first', ['json' => ['content']]);
			$data = array_values($blockData['Block']['content']);
			$keys = array_keys($blockData['Block']['content']);
			$count = $this->data('count', 0);
			//fix names
			$names = \G3\L\Arr::getVal($data, ['[n]', 'name'], []);
			//create new data
			$new_keys = range($count, $count + count($keys) - 1);
			$new_data = array_combine($new_keys, $data);
			$names = array_combine($new_keys, $names);
			
			$this->set('type', $data[0]['type']);
			$this->set('name', $data[0]['type'].$count);
			$this->set('count', $count);
			
			foreach($new_data as $k => $new_datav){
				$new_data[$k]['name'] = $new_data[$k]['type'].$k;
			}
			
			if($blockData['Block']['type'] == 'views'){
				$section = '_section';
				$single = 'view';
			}else{
				$section = '_event';
				$single = 'function';
			}
			
			foreach($new_data as $k => $new_datav){
				if(strpos($new_data[$k][$section], '/') !== false){
					$parent_name = explode('/', $new_data[$k][$section])[0];
					//fix the parent
					$parent_id = array_search($parent_name, $names);
					if(in_array($parent_id, $new_keys)){
						$new_data[$k][$section] = str_replace($parent_name.'/', $new_data[$parent_id]['name'].'/', $new_data[$k][$section]);
					}
				}else{
					//$new_data[$k][$section] = '';
					$this->set('name', $new_data[$k][$section]);
				}
			}
			
			$this->set('block_title', $blockData['Block']['title']);
			$this->set('block_id', $blockData['Block']['block_id']);
			
			$this->set($single, $new_data[$count]);
			$this->set($blockData['Block']['type'], $new_data);
			//pr($new_data);
			
			//$this->set('name', '');
			
			$this->data['Connection'][$blockData['Block']['type']] = $new_data;
			
			$this->view = 'block_config';
		}
	}
	
	function pages_config(){
		$page = $this->data('newpage', []);
		$pgcount = $this->data('pgcount');
		
		$pgroup = $this->data('pgroup');

		$this->set('page', $page);
		$this->set('pcount', $this->data('pages-count', 0));
		$this->set('pgroup', $pgroup);
		$this->set('pgcount', $pgcount);
		if(empty($page)){
			//new page group
			$this->view = 'pgroup_config';
			$this->set('pages', []);
		}
	}
	
	function pages_config_connectivity(){
		$this->set('name', $this->data('name'));
	}
	
	function preview_section(){
		$this->DataOps()->chunk('_formchunks');
		// pr($this->data);
		
		if(!empty($this->get('cf_settings.formeditor.safe_mode', true)) AND !empty($this->data('form_id'))){
				
			$connection = $this->Connection->where('id', $this->data('form_id'))->select('first', ['json' => ['settings', 'pgroups', 'pages', 'views', 'functions']]);
			if(!empty($connection)){
				foreach($this->data('Connection.views', []) as $uid => $unit){
					if(empty($unit['type'])){
						$this->data['Connection']['views'][$uid] = array_replace($connection['Connection']['views'][$uid], $this->data['Connection']['views'][$uid]);
					}
				}

				foreach($this->data('Connection.functions', []) as $uid => $unit){
					if(empty($unit['type'])){
						$this->data['Connection']['functions'][$uid] = array_replace($connection['Connection']['functions'][$uid], $this->data['Connection']['functions'][$uid]);
					}
				}
			}
		}

		$this->set('section', $this->data('__section'));
		$cdata = [];
		$cdata['views'] = [];
		foreach($this->data('Connection.views', []) as $k => $view){
			if(!empty($view['options'])){
				$view['foptions'] = $this->Parser->options($view['options']);
			}
			$view['datapath'] = [];
			$cdata['views'][$view['uid']] = $view;
			$area = !empty($view['_parent']) ? $view['_parent'].'/'.$view['_area'] : $view['_area'];
			$cdata['areas'][$area]['views'][] = $view['uid'];
		}
		
		$this->set('__cdata', $cdata);

		foreach($cdata['views'] as $uid => $unit){
			$unit['behaviors'] = ['html' => $unit['behaviors']['html'] ?? []];
			
			$this->Behaviors->apply('initialize', $unit);
			$this->Behaviors->apply('before_view', $unit);
		}
		
		$this->set('_preview', true);
	}
	
	function copy_element(){
		$utype = $this->data('utype');
		$this->set('utype', $utype);
		$area = '_area';
		// pr($this->data['Connection'][$utype]);
		$data = array_values($this->data['Connection'][$utype]);
		$keys = array_keys($this->data['Connection'][$utype]);
		$count = $this->data('count', 99);
		$this->set('count', $count);

		$units = [];
		foreach($this->data['Connection'][$utype] as $k => $unit){
			$this->data['Connection'][$utype][$k]['uid'] = $count;
			if(!empty($this->data['Connection'][$utype][$k]['_parent']) AND !empty($this->data['Connection'][$utype][$this->data['Connection'][$utype][$k]['_parent']])){
				$this->data['Connection'][$utype][$k]['_parent'] = $this->data['Connection'][$utype][$this->data['Connection'][$utype][$k]['_parent']]['uid'];
			}
			$this->data['Connection'][$utype][$k]['name'] = $this->data['Connection'][$utype][$k]['type'].$count;
			$units[$count] = $this->data['Connection'][$utype][$k];

			$count++;
		}
		$unit = array_values($units)[0];
		
		$this->set('type', $unit['type']);
		
		$this->set('unit', $unit);
		$this->set('units', $units);
		
		$this->data['Connection'][$utype] = $units;
		
		$this->view = 'units_config';
	}
	
	function refresh_element(){
		$utype = $this->data('utype');
		$this->set('utype', $utype);
		$area = '_area';

		if(!empty($this->get('cf_settings.formeditor.safe_mode', true)) AND !empty($this->data('Connection.id'))){
				
			$connection = $this->Connection->where('id', $this->data('Connection.id'))->select('first', ['json' => ['settings', 'pgroups', 'pages', 'views', 'functions']]);
			if(!empty($connection)){
				foreach($this->data('Connection.views', []) as $uid => $unit){
					if(empty($unit['type'])){
						$this->data['Connection']['views'][$uid] = array_replace($connection['Connection']['views'][$uid], $this->data['Connection']['views'][$uid]);
					}
				}

				foreach($this->data('Connection.functions', []) as $uid => $unit){
					if(empty($unit['type'])){
						$this->data['Connection']['functions'][$uid] = array_replace($connection['Connection']['functions'][$uid], $this->data['Connection']['functions'][$uid]);
					}
				}
			}
		}
		
		$data = array_values($this->data['Connection'][$utype]);
		$keys = array_keys($this->data['Connection'][$utype]);
		$count = $keys[0];
		
		$this->set('type', $data[0]['type']);
		// $this->set('name', $data[0]['name']);
		$this->set('count', $count);
		
		$this->set('unit', $data[0]);
		$this->set('units', $this->data['Connection'][$utype]);
		
		$this->view = 'units_config';
	}
	
	function save_block(){
		if(!empty($this->data['Connection'])){
			$Block = new \G3\A\E\Chronoforms\M\Block();
			$act = 'insert';
			
			if(!empty($this->data('block_id'))){
				$exists = $Block->where('block_id', $this->data('block_id'))->select('first');
				if(!empty($exists)){
					$Block->where('block_id', $this->data('block_id'));
					$Block->where('type', $this->data('type'));
					$act = 'update';
				}
			}
			
			$result = $Block->$act([
				'content' => $this->data['Connection'][$this->data('type')],
				'title' => $this->data['title'],
				'type' => $this->data('type'),
			], ['validate' => true, 'json' => ['content']]);
		}
		
		if($result === true){
			return ['success' => rl3('Block saved successfully.')];
		}else{
			return ['error' => rl3('Error saving block.'), 'reload' => true];
		}
	}
}
?>