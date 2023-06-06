<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(in_array($unit['type'], $behavior["accept"][$unit['utype']])){
		foreach($unit['datapath'] as $keysData => $dataname){
			if(!empty($this->data($dataname)) AND !empty($unit['image']['path'])){
				$encoded_image = explode(",", $this->data($dataname))[1];
				$decoded_image = base64_decode($encoded_image);
				$path = $this->controller->Parser->parse($unit['image']['path']);
				$saved = file_put_contents($path, $decoded_image);

				if($saved){
					$path_postfix = $this->controller->Parser->parse($unit['image']['path_postfix']);
					$name_postfix = $this->controller->Parser->parse($unit['image']['name_postfix']);
					$this->controller->Parser->pdata($dataname.$path_postfix, $path, true);
					$this->controller->Parser->pdata($dataname.$name_postfix, basename($path), true);
				}
			}
		}
	}