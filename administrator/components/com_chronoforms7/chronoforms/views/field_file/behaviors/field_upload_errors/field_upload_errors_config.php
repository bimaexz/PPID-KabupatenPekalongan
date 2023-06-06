<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('File upload extensions error'); ?></label>
		<input type="text" value="<?php echo $this->get('cf_settings.upload.errors.extensions', ''); ?>" name="Connection[views][<?php echo $n; ?>][fns][upload][fields][<?php echo $n; ?>][errors][extensions]">
		<small><?php el3('Error to display when the file extension is not permitted'); ?><?php el3(', Leave empty to use the global value'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('File upload size error'); ?></label>
		<input type="text" value="<?php echo $this->get('cf_settings.upload.errors.size', ''); ?>" name="Connection[views][<?php echo $n; ?>][fns][upload][fields][<?php echo $n; ?>][errors][size]">
		<small><?php el3('Error to display when the file size is overlimit'); ?><?php el3(', Leave empty to use the global value'); ?></small>
	</div>
</div>