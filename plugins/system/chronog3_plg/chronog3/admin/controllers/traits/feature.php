<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\C\T;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
trait Feature {
	
	function installFeature(){
		$session = \GApp3::session();
		
		if(isset($_FILES['upload'])){
			$upload = $_FILES['upload'];
			if(\G3\L\Upload::valid($upload) AND \G3\L\Upload::not_empty($upload) AND \G3\L\Upload::check_type($upload, 'zip')){
				
				// $pcs = explode('.', $upload['name']);
				// $type = array_shift($pcs).'s';
				
				$target = \G3\Globals::get('FRONT_PATH').'cache'.DS.rand().$upload['name'];
				$result = \G3\L\Upload::save($upload['tmp_name'], $target);
				if(empty($result)){
					$session->flash('error', rl3('Upload error.'));
					$this->redirect(r3('index.php?ext='.$this->extension.'&act=install_feature'));
				}
				//file upload, let's extract it
				$zip = new \ZipArchive();
				$handler = $zip->open($target);
				if($handler === true){
					$extract_path = \G3\Globals::ext_path($this->extension, 'admin');
					if(strpos($upload['name'], '.vendors') !== false){
						$extract_path = \G3\Globals::get('FRONT_PATH').DS.'vendors';
					}
					$zip->extractTo($extract_path);
					$zip->close();
					unlink($target);
					
					$session->flash('success', rl3('New feature was installed successfully.'));
					$this->redirect(r3('index.php?ext='.$this->extension));
				}else{
					$session->flash('error', rl3('Error extracting file.'));
					$this->redirect(r3('index.php?ext='.$this->extension.'&act=install_feature'));
				}
			}else{
				$session->flash('error', rl3('File missing or incorrect.'));
				$this->redirect(r3('index.php?ext='.$this->extension.'&act=install_feature'));
			}
		}elseif(!empty($this->data('url'))){
			//pr(file_get_contents(base64_decode($this->data('url'))));
		}
	}
	
}
?>