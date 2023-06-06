<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if($this->controller->Page->check_page_type($page['pageid'], 'end')){
		if(!empty($unit['admin_email']['body'])){
			$function = [
				'type' => 'email',
				'name' => $unit['utype'].'_admin_email',
			];

			$function = array_merge($function, $unit['admin_email']);
			echo $this->controller->Page->fn($function);
		}
	}