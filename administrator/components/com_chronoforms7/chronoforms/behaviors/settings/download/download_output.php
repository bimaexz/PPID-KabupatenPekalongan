<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if($task == 'download'){
		if(!empty($this->data['file'])){
			$filename = str_replace(['\\', '/', '..'], '', $this->data['file']);
			$path = !empty($this->get('cf_settings.upload.path')) ? $this->get('cf_settings.upload.path') : \G3\Globals::ext_path(\GApp3::instance()->extension, 'front').'uploads'.DS;
			$path = str_replace(array('/', '\\'), DS, $path);

			$path .= $filename;

			$function = [
				'type' => 'download',
				'name' => $unit['utype'].'_download',
				'path' => $path,
			];
			
			$function = array_merge($function, $unit['download'] ?? []);
			$this->controller->Page->fn($function);
		}
	}