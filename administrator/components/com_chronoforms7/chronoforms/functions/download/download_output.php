<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($function['path'])){
		
		$path = $this->Parser->parse(trim($function['path']));
		
		if(is_dir($path)){
			if(!empty($function['selection'])){
				//get last modified file
				$latest_ctime = 0;
				$latest_filename = '';    

				$d = dir($path);
				
				while(false !== ($entry = $d->read())){
					
					$filepath = $path.DS.$entry;
					if(is_file($filepath) AND filectime($filepath) > $latest_ctime){
						$latest_ctime = filectime($filepath);
						$latest_filename = $entry;
					}
				}
				
				if(!empty($latest_filename)){
					$path = $path.DS.$latest_filename;
				}
			}
		}
		
		if(file_exists($path) AND is_file($path)){
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			
			$inline_extensions = [];
			
			if(!empty($function['inline_extensions'])){
				$inline_extensions = $function['inline_extensions'];
			}
			
			$view = 'D';
			
			if(in_array(strtolower($ext), $inline_extensions)){
				$view = 'I';
			}
			
			$this->Parser->end();
			
			\G3\L\Download::send($path, $view, basename($path));
		}else{
			$this->fevents[$function['name']]['file_not_found'] = true;
			$this->errors[$function['name']] = rl3('File does not exist.');
		}
		
	}else{
		$this->errors[$function['name']] = rl3('Empty file path.');
	}