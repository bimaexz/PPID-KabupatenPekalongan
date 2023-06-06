<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\E\Chronoforms\C;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Locales extends \G3\A\E\Chronoforms\App {
	use \G3\A\C\T\DataOps;
	
	var $_models = array(
		'\G3\A\E\Chronoforms\M\Locale',
	);
	
	function index(){
		//search
		$this->Search($this->Locale, ['title', 'locales']);
		
		$this->Paginate($this->Locale);
		
		$this->Order($this->Locale, ['Locale.title', 'Locale.id', 'Locale.enabled']);
		
		$locales = $this->Locale->select('all', ['json' => ['locales']]);
		$this->set('locales', $locales);
	}
	
	function edit(){
		
		if(isset($this->data['save']) OR isset($this->data['apply'])){
			$result = false;
			
			if(!empty($this->data['Locale'])){
				//update locales data to ini format
				if(!empty($this->data['Locale']['locales'])){
					foreach($this->data['Locale']['locales'] as $ltag => $ldata){
						if(!empty($ldata['content'])){
							$lines2 = [];
							$lines = explode("\n", $ldata['content']);
							foreach($lines as $k => $line){
								$parts = explode('=', $line);
								if(count($parts) > 1){
									$parts[0] = \G3\L\Str::clean($parts[0], 'ini_var');
									$parts[1] = '"'.str_replace('"', '', trim($parts[1])).'"';
								}else{

								}
								$lines2[] = $parts[0].'='.$parts[1];
							}
							$this->data['Locale']['locales'][$ltag]['content'] = implode("\n", $lines2);
						}
					}
				}
				
				$result = $this->Locale->save($this->data['Locale'], ['validate' => true, 'alias' => ['title' => 'alias'], 'json' => ['locales']]);
			}
			
			if($result === true){
				
				if(isset($this->data['apply'])){
					$redirect = r3('index.php?ext=chronoforms&cont=locales&act=edit&id='.$this->Locale->id);
				}else{
					$redirect = r3('index.php?ext=chronoforms&cont=locales');
				}
				return ['success' => rl3('Locale updated successfully.'), 'redirect' => $redirect];
			}else{
				
				$this->errors['Locale'] = $this->Locale->errors;
				unset($this->data['save']);
				unset($this->data['apply']);
				return ['error' => $this->Locale->errors, 'reload' => true];
			}
		}
		
		if(!empty($this->data['id'])){
			$locale = $this->Locale->where('id', $this->data('id', null))->select('first', ['json' => ['locales']]);
		}else{
			$locale = ['Locale' => ['locales' => [['name' => \G3\L\Config::get('site.language'), 'content' => '']]]];
		}

		if(!empty($locale)){
			$this->data = array_merge($this->data, $locale);
		}
		
		$this->set('locale', $locale);
	}
	
	function toggle(){
		return $this->toggleRecord($this->Locale);
	}
	
	function delete(){
		return $this->deleteRecord($this->Locale);
	}
	
	function copy(){
		if(is_array($this->data('gcb'))){
			
			$results = $this->Locale->where('id', $this->data('gcb'), 'in')->select();
			
			foreach($results as $result){
				unset($result['Locale']['id']);
				$result['Locale']['title'] = $result['Locale']['title'].' - copy';
				$this->Locale->save($result['Locale']);
			}
		}
		
		$this->redirect(r3('index.php?ext=chronoforms&cont=locales'));
	}

	function locales_config(){
		$this->set('name', $this->data('name'));
	}
	
	function backup(){
		
		if(is_array($this->data('gcb'))){
			
			$results = $this->Locale->where('id', $this->data('gcb'), 'in')->select();
			$output = json_encode($results);
			
			$name = 'Chronoforms7Locales_'.\G3\L\Url::domain();
			if(count($results) == 1){
				$name = $results[0]['Locale']['title'];
			}
			
			//download the file
			if(preg_replace('Opera(/| )([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])){
				$UserBrowser = 'Opera';
			}elseif(preg_replace('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])){
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
				header('Content-Disposition: inline; filename="' . $name.'_'.date('d_M_Y_H:i:s').'.cf7locale"');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
			}
			else {
				header('Content-Disposition: attachment; filename="' . $name.'_'.date('d_M_Y_H:i:s').'.cf7locale"');
				header('Pragma: no-cache');
			}
			print $output;
			exit();
		}
		
		$this->redirect(r3('index.php?ext=chronoforms&cont=locales'));
	}
	
	function restore(){
		if(!empty($_FILES)){
			$file = $_FILES['backup'];
			
			if(!empty($file['size'])){
				
				$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
				
				if($ext != 'cf7locale'){
					\GApp3::session()->flash('error', rl3('Invalid locale backup file extension.'));
					$this->redirect(r3('index.php?ext=chronoforms&cont=locales'));
				}
				
				$target = \G3\Globals::get('FRONT_PATH').'cache'.DS.$file['name'];
				
				$saved = \G3\L\Upload::save($file['tmp_name'], $target);
				
				if(!$saved){
					\GApp3::session()->flash('error', l_('Upload error'));
				}else{
					if($ext == 'cf7locale'){
						$data = file_get_contents($target);
						\G3\L\File::delete($target);
						
						$rows = json_decode($data, true);
						
						if(!empty($rows)){
							$bids = \G3\L\Arr::getVal($rows, '[n].Locale.locale_id', []);
							$bids = array_filter($bids);
							if(!empty($bids)){
								$this->Locale->where('locale_id', $bids, 'in')->delete();
							}
							
							foreach($rows as $row){
								if(isset($row['Locale']['id'])){
									$row['Locale']['id'] = null;
									//$row['Locale']['published'] = 0;
									$this->Locale->save($row['Locale']);
								}
							}
						}
					}
					
					\GApp3::session()->flash('success', rl3('Locales restored successfully.'));
					$this->redirect(r3('index.php?ext=chronoforms&cont=locales'));
				}
			}
		}
	}
}
?>