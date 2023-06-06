<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Max size exceeded error'); ?></label>
		<input type="text" value="<?php echo $this->get('cf_settings.upload.errors.size', ''); ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][errors][size]">
	</div>

	<div class="field">
		<label><?php el3('File extension error'); ?></label>
		<input type="text" value="<?php echo $this->get('cf_settings.upload.errors.extensions', ''); ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][errors][extensions]">
	</div>
</div>