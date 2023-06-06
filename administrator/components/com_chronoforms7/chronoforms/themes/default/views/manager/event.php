<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$output = $event_output;

	if(!empty($display['views'])){
		foreach($display['views'] as $view){
			$output .= $this->Parser->view($view);
		}
	}else if(!empty($display['sections'])){
		if($this->data('gact') != 'ajax'){
			echo \G3\H\Message::render(\GApp3::session()->flash());
		}else{
			echo \G3\H\Message::render(\GApp3::session()->flash(), 'toast');
		}

		foreach($display['sections'] as $section){
			$output .= $this->Parser->section($section);
		}
	}
	
	echo $output;