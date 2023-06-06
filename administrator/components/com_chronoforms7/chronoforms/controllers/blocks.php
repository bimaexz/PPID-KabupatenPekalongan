<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\E\Chronoforms\C;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Blocks extends \G3\A\E\Chronoforms\App {
	use \G3\A\C\T\DataOps;
	
	var $models = array(
		'\G3\A\E\Chronoforms\M\Block',
		'\G3\A\M\Group'
	);
	var $helpers= array(
		'\G3\A\E\Chronoforms\H\Field',
		'\G3\A\E\Chronoforms\H\Parser',
	);
	
	function index(){
		//search
		$this->Search($this->Block, ['title', 'desc']);
		
		$this->Paginate($this->Block);
		
		$this->Order($this->Block, ['block_title' => 'Block.title', 'block_id' => 'Block.id', 'block_published' => 'Block.published']);
		
		$blocks = $this->Block->select('all', ['json' => ['content']]);
		$this->set('blocks', $blocks);
	}
	
	function edit(){
		
		if(isset($this->data['save']) OR isset($this->data['apply'])){
			$result = false;
			
			$this->DataOps()->chunk('_formchunks');
			
			$this->data['Block']['content'] = $this->data['Connection'][$this->data['Block']['type']];
			
			if(!empty($this->data['Block'])){
				$result = $this->Block->save($this->data['Block'], ['validate' => true, 'json' => ['params', 'content', 'rules'], 'alias' => ['title' => 'block_id']]);
			}
			
			if($result === true){
				
				if(isset($this->data['apply'])){
					$redirect = r3('index.php?ext=chronoforms&cont=blocks&act=edit&id='.$this->Block->id);
				}else{
					$redirect = r3('index.php?ext=chronoforms&cont=blocks');
				}
				return ['success' => rl3('Block updated successfully.'), 'redirect' => $redirect];
			}else{
				
				$this->errors['Block'] = $this->Block->errors;
				unset($this->data['save']);
				unset($this->data['apply']);
				return ['error' => $this->Block->errors, 'reload' => true];
			}
		}
		
		if(!empty($this->data['id'])){
			$block = $this->Block->where('id', $this->data('id', null))->select('first', ['json' => ['params', 'events', 'content', 'sections', 'views', 'functions', 'locales', 'rules']]);
			if(!empty($block)){
				$this->data = array_merge($this->data, $block);
			}
			$this->set('block', $block);
			
			$this->data['Connection'][$this->data['Block']['type']] = $this->data['Block']['content'];
		}
		
		//get first item section/event name
		if(!empty($this->data['Block']['content'])){
			$items = array_values($this->data['Block']['content']);
			if($this->data['Block']['type'] == 'views'){
				$this->data['sections'] = [
					$items[0]['_section'] => ['name' => $items[0]['_section'], 'content' => ''],
				];
			}else{
				$this->data['events'] = [
					$items[0]['_event'] => ['name' => $items[0]['_event'], 'content' => ''],
				];
			}
		}else{
			if($this->data['Block']['type'] == 'views'){
				$this->data['sections'] = [
					'new' => ['name' => 'new', 'content' => ''],
				];
			}else{
				$this->data['events'] = [
					'new' => ['name' => 'new', 'content' => ''],
				];
			}
		}
		
		//get users groups for permissions
		$_groups = $this->Group->select('flat');
		$this->set('_groups', $_groups);
		$groups = array_merge([['Group' => ['id' => 'owner', 'title' => rl3('Owner'), '_depth' => 0]]], $_groups);
		$this->set('groups', $groups);
	}
	
	function toggle(){
		return $this->toggleRecord($this->Block);
	}
	
	function delete(){
		return $this->deleteRecord($this->Block);
	}
	
	function copy(){
		if(is_array($this->data('gcb'))){
			
			$results = $this->Block->where('id', $this->data('gcb'), 'in')->select();
			
			foreach($results as $result){
				unset($result['Block']['id']);
				$result['Block']['title'] = $result['Block']['title'].' - copy';
				$this->Block->save($result['Block']);
			}
		}
		
		$this->redirect(r3('index.php?ext=chronoforms&cont=blocks'));
	}
	
	function backup(){
		
		if(is_array($this->data('gcb'))){
			
			$results = $this->Block->where('id', $this->data('gcb'), 'in')->select();
			$output = json_encode($results);
			
			$name = 'Chronoforms7Blocks_'.\G3\L\Url::domain();
			if(count($results) == 1){
				$name = $results[0]['Block']['title'];
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
				header('Content-Disposition: inline; filename="' . $name.'_'.date('d_M_Y_H:i:s').'.cf7block"');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
			}
			else {
				header('Content-Disposition: attachment; filename="' . $name.'_'.date('d_M_Y_H:i:s').'.cf7block"');
				header('Pragma: no-cache');
			}
			print $output;
			exit();
		}
		
		$this->redirect(r3('index.php?ext=chronoforms&cont=blocks'));
	}
	
	function restore(){
		if(!empty($_FILES)){
			$file = $_FILES['backup'];
			
			if(!empty($file['size'])){
				
				$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
				
				if($ext != 'cf7block'){
					\GApp3::session()->flash('error', rl3('Invalid block backup file extension.'));
					$this->redirect(r3('index.php?ext=chronoforms&cont=blocks'));
				}
				
				$target = \G3\Globals::get('FRONT_PATH').'cache'.DS.$file['name'];
				
				$saved = \G3\L\Upload::save($file['tmp_name'], $target);
				
				if(!$saved){
					\GApp3::session()->flash('error', l_('Upload error'));
				}else{
					if($ext == 'cf7block'){
						$data = file_get_contents($target);
						\G3\L\File::delete($target);
						
						$rows = json_decode($data, true);
						
						if(!empty($rows)){
							$bids = \G3\L\Arr::getVal($rows, '[n].Block.block_id', []);
							$bids = array_filter($bids);
							if(!empty($bids)){
								$this->Block->where('block_id', $bids, 'in')->delete();
							}
							
							foreach($rows as $row){
								if(isset($row['Block']['id'])){
									$row['Block']['id'] = null;
									//$row['Block']['published'] = 0;
									$this->Block->save($row['Block']);
								}
							}
						}
					}
					
					\GApp3::session()->flash('success', rl3('Blocks restored successfully.'));
					$this->redirect(r3('index.php?ext=chronoforms&cont=blocks'));
				}
			}
		}
	}
}
?>