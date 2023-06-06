<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui segment" id="flownode-config-<?php echo $uid; ?>">
	<?php
		require($config_file);
	?>
</div>