<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\E\Chronoforms\C;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Backups extends \G3\A\E\Chronoforms\App {
	use \G3\A\C\T\DataOps;

	var $_libs = array(
		
	);
	
	var $_models = array(
		'\G3\A\E\Chronoforms\M\Backup', 
	);
	
	var $_helpers = array(
		
	);

	function restore(){
		if(!empty($_FILES)){
			$file = $_FILES['backup'];
			
			if(!empty($file['size'])){
				
				$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
				
				if($ext != 'sql'){
					\GApp3::session()->flash('error', rl3('Invalid backup file extension.'));
					$this->redirect(r3('index.php?ext=chronoforms&cont=connections'));
				}
				
				$target = \G3\Globals::get('CACHE_PATH').$file['name'];
				
				$saved = \G3\L\Upload::save($file['tmp_name'], $target);
				
				if(!$saved){
					\GApp3::session()->flash('error', l_('Upload error'));
				}else{
					if($ext == 'sql'){
						$sql_block = '';

						$file = new \SplFileObject($target);
						while($file->valid()){
							if($line = $file->fgets()){
								if(trim($line) == '--startsqlblock'){
									$sql_block = '';
								}else if(trim($line) == '--endsqlblock'){
									//run sql
									// \G3\L\Database::getInstance()->exec($sql_block);
									pr($sql_block);
								}else{
									$sql_block .= $line;
								}
							}
						}
					}
				}
			}
		}
	}

	function index(){
		$this->connect();
	}

	function connect($id = ''){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, r3('index.php?ext=chronoforms&cont=backups&act=status&tvout=view&id='.$id, ['absolute' => true]));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_TIMEOUT_MS, 400);     //just some very short timeout        
		curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
		curl_exec($ch);
		curl_close($ch);
	}

	function status(){
		$backup = $this->Backup->order(['created' => 'desc', 'id' => 'desc'])->select('first', ['json' => ['data']]);

		if(!empty($backup) AND empty($backup['Backup']['finished']) AND empty($_GET['id'])){
			//new backup while one is running
			return;
		}

		$new = false;
		if(empty($backup) OR !empty($backup['Backup']['finished'])){
			//new backup start
			$backup = [
				'Backup' => [
					'id' => \G3\L\Dater::datetime('Y_m_d__h_i_s'),//\G3\L\Str::uuid(),
					'status' => 'start_sql',
					'data' => [
						
					],
				]
			];

			$new = true;
		}

		$status = $backup['Backup']['status'];
		$data = $backup['Backup']['data'];
		$id = $backup['Backup']['id'];

		$db_backup_file = JPATH_ROOT.DS.'tmp'.DS.$id.'_database.sql';
		$files_zipfile = JPATH_ROOT.DS.'tmp'.DS.$id."_files.zip";
		$limit_sql = 50;
		$limit_files = 250;

		if($new){
			if(file_exists($db_backup_file)){
				unlink($db_backup_file);
			}
		}
		
		$run = true;
		// if(!empty($backup) AND $backup['Backup']['status'] == 'complete'){
		// 	$run = false;
		// 	if((time() - strtotime($backup['Backup']['created'])) >= $this->get('cf_settings.backups.freq', 100)){
		// 		$run = true;
		// 	}
		// }

		if($run){
			$dbo = \G3\L\Database::getInstance();
			$db_tables = array_values($dbo->getTablesList());

			$no_data_tables = [
				$dbo->_prefixTable($this->Backup->tablename), 
				$dbo->_prefixTable('#__session')
			];

			$omitted_folders = [
				JPATH_ROOT.DS.'tmp'.DS, 
				JPATH_ROOT.DS.'cache'.DS
			];

			if($backup['Backup']['status'] == 'running_db_sql'){
				$skip_table_data = in_array($data['table'], $no_data_tables);
				$table_total_reached = ((int)$data['offset'] >= (int)$data['total']);
				
				if($skip_table_data OR $table_total_reached){
					$last_table_index = array_search($data['table'], $db_tables);

					if($last_table_index + 1 >= count($db_tables)){
						$status = 'zipping_sql';
						// $status = 'running_files';
					}else{
						$next_table = $db_tables[$last_table_index + 1];
						$Table = new \G3\L\Model(['name' => 'Table', 'table' => $next_table]);
						$total = $Table->select('count');
						
						$data = array_replace($data, [
							'table' => $next_table,
							'offset' => 0,
							'total' => (int)$total,
						]);
					}
				}else{
					$data['offset'] = $data['offset'] + $limit_sql;
				}

			}else if($backup['Backup']['status'] == 'start_sql'){
				$first_table = array_shift($db_tables);
				$Table = new \G3\L\Model(['name' => 'Table', 'table' => $first_table]);
				$total = $Table->select('count');

				$data = [
					'table' => $first_table,
					'offset' => 0,
					'total' => (int)$total,
				];

				$status = 'running_db_sql';

			}else if($backup['Backup']['status'] == 'zipping_sql'){
				$zip = new \ZipArchive();
				$db_zipfile = $db_backup_file."_zipped.zip";
				
				if(file_exists($db_zipfile)){
					unlink($db_zipfile);
				}

				if($zip->open($db_zipfile, \ZIPARCHIVE::CREATE) === TRUE){
					$zip->addFile($db_backup_file, basename($db_backup_file));
					$zip->close();
					// $status = 'complete';
					$status = 'running_files';
				}else{
					$status = 'failed_zipping_database';
				}

			}else if($backup['Backup']['status'] == 'running_files'){
				$folder = JPATH_ROOT.DS.'modules'.DS;
				
				$zip = new \ZipArchive();
				
				$zip_exists = true;
				if(!file_exists($files_zipfile)){
					// unlink($files_zipfile);
					$zip_exists = $zip->open($files_zipfile, \ZIPARCHIVE::CREATE);
				}else{
					$zip_exists = $zip->open($files_zipfile);
				}

				if($zip_exists === TRUE){
					$children = \G3\L\Folder::getFiles($folder);
					$children = array_values(array_diff($children, $omitted_folders));

					$stop = false;

					if(empty($data['file'])){
						$data['file'] = array_shift($children);
					}else{
						$last_file_index = array_search($data['file'], $children);
						if($last_file_index + 1 >= count($children)){
							$stop = true;
							$status = 'complete';
						}else{
							if(empty($data['files_shift'])){
								$data['file'] = $children[array_search($data['file'], $children) + 1];
							}
						}
					}
					
					if(!$stop){
						$file = $data['file'];
						$files_added = 0;
						$files_limit_reached = false;
						if(is_dir($file)){
							$file_children = \G3\L\Folder::getFiles($file, true);
							if(!empty($data['files_shift'])){
								$file_children = array_slice($file_children, $data['files_shift']);
							}
							foreach($file_children as $_file){
								$relativePath = substr($_file, strlen($folder));
								$zip->addFile($_file, $relativePath);
								$files_added++;
								if($files_added == $limit_files){
									$files_limit_reached = true;
									$data['files_shift'] = ($data['files_shift'] ?? 0) + $files_added;
									break;
								}
							}

							if(!$files_limit_reached AND !empty($data['files_shift'])){
								$data['files_shift'] = 0;
							}
						}else{
							$relativePath = substr($file, strlen($folder));
							$zip->addFile($file, $relativePath);
						}
					}else{
						$status = 'complete';
					}

					$zip->close();
				}else{
					$status = 'failed_zipping_files';
				}
			}

			if(strpos($status, '_db_sql') !== false){
				$handle = fopen($db_backup_file, 'a');

				if($handle !== false){
					if($data['offset'] == 0){
						$create_table_sql = $dbo->getTableSql($data['table']);
						$create_table_sql = '--startsqlblock'."\n".$create_table_sql;
						$create_table_sql = str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $create_table_sql);
						$create_table_sql = str_replace("datetime NOT NULL DEFAULT '0000-00-00 00:00:00'", "datetime  NULL", $create_table_sql);
						$create_table_sql .= ';';
						$create_table_sql .= "\n".'--endsqlblock'."\n\n";
						fwrite($handle, $create_table_sql);
						fclose($handle);
					}
				}

				// $data['offset'] = $data['offset'] + $limit_sql;

				if(!in_array($data['table'], $no_data_tables)){
					$Table = new \G3\L\Model(['name' => 'Table', 'table' => $data['table']]);
					$rows = $Table->offset($data['offset'])->limit($limit_sql)->select('all');

					$rows_sql = '--startsqlblock'."\n";
					if(!empty($rows)){
						$rows_sql .= 'INSERT INTO `'.$data['table'].'` (';
						$rows_sql .= '`'.implode('`, `', $Table->tablefields).'`';
						$rows_sql .= ') VALUES';
						$rows_sql .= "\n";
						foreach($rows as $rk => $row){
							$rows_sql .= "(";
							$nrow = [];
							foreach($Table->tablefields as $field){
								if(!isset($row['Table'][$field])){
									$nrow[$field] = "NULL";
								}else{
									$nrow[$field] = "'".addslashes($row['Table'][$field])."'";
								}
							}
							$rows_sql .= implode(', ', $nrow);
							$rows_sql .= ")";
							$rows_sql .= ($rk == count($rows) - 1) ? ";\n" : ",\n";
						}
						$rows_sql .= '--endsqlblock'."\n\n";

						$handle = fopen($db_backup_file, 'a');
						fwrite($handle, $rows_sql);
						fclose($handle);
					}
				}
			}

			$finished = 0;
			if($new){
				$result = $this->Backup->insert([
					'created' => \G3\L\Dater::datetime(),
					// 'modified' => \G3\L\Dater::datetime(),
					'status' => $status,
					'data' => $data,
					'id' => $id,
				], ['json' => ['data']]);
			}else{
				if($status == 'complete' OR (strpos($status, 'failed_') !== false)){
					$finished = 1;
				}

				$result = $this->Backup->where('id', $id)->update([
					// 'created' => \G3\L\Dater::datetime(),
					'modified' => \G3\L\Dater::datetime(),
					'status' => $status,
					'finished' => $finished,
					'data' => $data,
				], ['json' => ['data']]);
			}

			if($result === true){
				if(!$finished){
					$this->connect($id);
				}
			}
			// \GApp3::redirect(r3('index.php?ext=chronobackup&cont=backups&act=status&tvout=view', ['absolute' => true]));
		}
	}

}
?>