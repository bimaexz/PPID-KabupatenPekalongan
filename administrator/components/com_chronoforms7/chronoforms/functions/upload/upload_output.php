<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	
	$_result = [];
	// $_errors = [];
	$_debug = [];
	
	$upload_save_file = function($name, $extensions, $path, $size, $errors, $vuid) use ($function){
		$path = $this->Parser->parse($path);
		
		$pathinfo = pathinfo(\G3\L\Upload::get($name, 'name'));
		if(empty($pathinfo['filename'])){
			return false;
		}
		$ext = $pathinfo['extension'];
		$fname = $pathinfo['filename'];
		
		if(!in_array(strtolower($ext), $extensions)){
			$this->errors[] = $this->Parser->parse($errors['extensions']);
			return false;
		}
		
		if(\G3\L\Upload::get($name, 'size')/1000 > (int)$size){
			$this->errors[] = $this->Parser->parse($errors['size']);
			return false;
		}
		
		if(!empty($function['filename_provider'])){
			$this->set($function['name'].'.file.fullname', \G3\L\Upload::get($name, 'name'));
			$this->set($function['name'].'.file.name', $fname);
			$this->set($function['name'].'.file.extension', $ext);
			
			$vfilename = $this->Parser->parse($function['filename_provider']);
		}else{
			$fname = \G3\L\Str::slug($fname);
			
			$fname = \G3\L\Dater::datetime('YmdHis').'_'.$fname;
			$vfilename = $fname.'.'.$ext;
		}
		
		$target = $path.$vfilename;
		
		$saved = \G3\L\Upload::save(\G3\L\Upload::get($name, 'tmp_name'), $target);

		$return = [];

		$function = $this->controller->Behaviors->apply('file_upload', $function, [
			// '_local' => true,
			'file' => [
				'name' => \G3\L\Upload::get($name, 'name'),
				'path' => $target,
				'fieldname' => $name,
			],
			'return' => &$return,
		]);

		if(!empty($this->errors)){
			return false;
		}
		
		if($saved){
			if(true){ // check the google drive upload flag
				$gdfiles = $this->controller->FData->cdata('views.'.$vuid.'.fns.google_drive_upload.files.'.$vuid, []);
				$gdfiles[] = ['path' => $target, 'fieldname' => $name];
				$this->controller->FData->cdata('views.'.$vuid.'.fns.google_drive_upload.files.'.$vuid, $gdfiles, true);
			}
			$return['path'] = $target;
			$return['filename'] = $vfilename;
			$return['name'] = \G3\L\Upload::get($name, 'name');
			$return['size'] = filesize($target);
			$return['url'] = $this->Parser->parse('{url.full:load&dtask=download&file='.$vfilename.'}');
			
			return $return;
		}
	};
	
	if(!empty($function['path'])){
		$path = trim($function['path']);
		$path = $this->Parser->parse($path);
		$path = str_replace(array('/', '\\'), DS, $path);
		$path = rtrim($path, DS).DS;
	}else{
		$path = !empty($this->get('cf_settings.upload.path')) ? $this->get('cf_settings.upload.path') : \G3\Globals::ext_path(\GApp3::instance()->extension, 'front').'uploads'.DS;
		$path = str_replace(array('/', '\\'), DS, $path);
		unset($function['path']);
	}
	
	$this->debug[$function['name']]['path'] = $path;
	
	if(!file_exists($path)){
		$this->errors[] = rl3('Destination directory not available.');
	}else if(!is_writable($path)){
		$this->errors[] = rl3('Destination directory not writable.');
	}
	
	if(!empty($this->errors)){
		$this->set($function['name'], false);
		$this->fevents[$function['name']]['fail'] = true;
		return;
	}
	
	$processed = [];
	
	$upload_set_data = function($returned, $name, $page) use (&$_result, $function){
		if(!empty($returned)){
			//$_result[$name] = $returned;
			$_result = \G3\L\Arr::setVal($_result, $name, $returned);
			//$this->data[$name] = $returned['filename'];
			$this->controller->Parser->pdata($name, $returned['filename'], $page);
			// $this->debug[$function['name']][$name]['saved'] = 1;
			$this->debug = \G3\L\Arr::setVal($this->debug, $function['name'].'.'.$name.'.saved', true);
			return true;
		}else{
			//$_result = false;
			$_result = \G3\L\Arr::setVal($_result, $name, []);
			$this->controller->Parser->pdata($name, null, $page);
			// $this->debug[$function['name']][$name]['saved'] = 0;
			$this->debug = \G3\L\Arr::setVal($this->debug, $function['name'].'.'.$name.'.saved', false);
			//break;
			return false;
		}
	};
	
	$_return = true;
	
	if(!empty($function['fields'])){
		foreach($function['fields'] as $vuid => $config){
			$fname = $config['fieldname'];
			if(in_array($fname, $processed)){
				continue;
			}
			$processed[] = $fname;
			
			$extensions = [];

			$extensions = $config['extensions'] ?? $function['extensions'] ?? $this->get('cf_settings.upload.extensions', ['jpg', 'jpeg', 'png', 'pdf', 'txt']);
			
			$size = $this->Parser->parse($config['size'] ?? $function['size'] ?? $this->get('cf_settings.upload.size'));

			$path = $config['path'] ?? $function['path'] ?? $path;
			
			$errors = $config['errors'] ?? $function['errors'] ?? $this->get('cf_settings.upload.errors');

			$page = $config['page'] ?? $this->controller->FData->sessiondata('pages.this');
			
			foreach($fname as $keysData => $dataname){
				// $this->debug[$function['name']][$dataname]['extensions'] = $extensions;
				$this->debug = \G3\L\Arr::setVal($this->debug, $function['name'].'.'.$dataname.'.extensions', $extensions);

				// pr($_FILES);pr($name);pr(\G3\L\Upload::get($name, 'name'));die();
				
				if(empty($extensions) OR empty($dataname) OR empty(\G3\L\Upload::get($dataname, 'name'))){
					// $this->debug[$function['name']][$dataname]['info'] = rl3('File is not present.');
					$this->debug = \G3\L\Arr::setVal($this->debug, $function['name'].'.'.$dataname.'.info', rl3('File is not present.'));
					continue;
				}

				$files = \G3\L\Upload::get($dataname, 'name');

				if(!is_array($files)){
					$returned = $upload_save_file($dataname, $extensions, $path, $size, $errors, $vuid);
					$_return = $upload_set_data($returned, $dataname, $page);
					if($_return === false){
						break 2;
					}
				}else{
					foreach($files as $kf => $file){
						$sub_name = $dataname.'.'.$kf;
						
						if(!empty(\G3\L\Upload::get($sub_name, 'name'))){//do not try to empty file with multiple attr
							$returned = $upload_save_file($sub_name, $extensions, $path, $size, $errors, $vuid);
							$_return = $upload_set_data($returned, $sub_name, $page);
							if($_return === false){
								break 3;
							}
						}
					}
				}
			}
			
			// if(!empty($config['multiple']) OR strpos($name, '[n]') !== false){
			// 	$files_names = \G3\L\Upload::get($name, 'name');
			// 	//$keys = array_keys($files_names);
			// 	//foreach($keys as $key){
			// 	foreach($files_names as $key => $files){
			// 		//$sub_name = str_replace('[n]', $key, $name);
			// 		$sub_name = implode($key, explode('[n]', $name, 2));
					
			// 		if(!is_array($files)){
			// 			$returned = $upload_save_file($sub_name, $extensions, $path, $size, $errors);
			// 			$_return = $upload_set_data($returned, $sub_name);
			// 			if($_return === false){
			// 				break 2;
			// 			}
			// 		}else{
			// 			foreach($files as $kf => $file){
			// 				$sub_name2 = implode($kf, explode('[n]', $sub_name, 2));
							
			// 				$returned = $upload_save_file($sub_name2, $extensions, $path, $size, $errors);
			// 				$_return = $upload_set_data($returned, $sub_name2);
			// 				if($_return === false){
			// 					break 3;
			// 				}
			// 			}
			// 		}
			// 	}
			// }else{
			// 	$returned = $upload_save_file($name, $extensions, $path, $size, $errors);
			// 	$_return = $upload_set_data($returned, $name);
			// 	if($_return === false){
			// 		break;
			// 	}
			// }
			
		}
		
	}else{
		//$_errors[] = rl3('Files config is empty');
		//$_result = false;
	}
	
	if($_return === false){
		$this->fevents[$function['name']]['fail'] = true;
		//the whole upload fails when one file fails
		$_result = false;
	}else{
		$this->fevents[$function['name']]['success'] = true;
	}

	$this->set($function['name'], $_result);