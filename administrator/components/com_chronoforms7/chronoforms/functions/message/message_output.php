<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$type = $this->Parser->parse($function['message_type'] ?? 'success');
	$content = $this->Parser->parse($function['content']);
	
	\GApp3::session()->flash($type, $content);

	// if(empty(\GApp3::instance()->tvout)){
	// 	// \GApp3::message($type, $content);
	// 	\GApp3::session()->flash($type, $content);
	// }else{
	// 	echo '
	// 	<script type="text/javascript">
	// 		jQuery(document).ready(function($){
	// 			$("body").toast({
	// 				class: "'.$type.'",
	// 				message: "'.$content.'",
	// 				position: "top center",
	// 			});
	// 		});
	// 	</script>';
	// }
	