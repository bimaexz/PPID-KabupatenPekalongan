<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('File upload extensions'); ?></label>
		<select name="Connection[views][<?php echo $n; ?>][fns][upload][fields][<?php echo $n; ?>][extensions][]" multiple="" class="ui fluid dropdown search" data-clearable="1" data-allowadditions="1">
			<?php foreach($this->get('cf_settings.upload.extensions', []) as $ext): ?>
				<option value="<?php echo $ext; ?>" selected="selected"><?php echo $ext; ?></option>
			<?php endforeach; ?>
		</select>
		<small><?php el3('Comma separated list of permitted extensions'); ?><?php el3(', Leave empty to use the global value'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('File upload max size'); ?></label>
		<input type="text" value="<?php echo $this->get('cf_settings.upload.size', ''); ?>" name="Connection[views][<?php echo $n; ?>][fns][upload][fields][<?php echo $n; ?>][size]">
		<small><?php el3('Allowed maximum file size in KB'); ?><?php el3(', Leave empty to use the global value'); ?></small>
	</div>
</div>