<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Upload directory path'); ?></label>
	<input type="text" value="{path:front}<?php echo DS.'uploads'.DS; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][path]">
</div>

<div class="field">
	<label><?php el3('Default Allowed extensions list'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][extensions][]" multiple="" class="ui fluid dropdown search" data-clearable="1" data-allowadditions="1">
		<?php foreach($this->get('cf_settings.upload.extensions', []) as $ext): ?>
			<option value="<?php echo $ext; ?>" selected="selected"><?php echo $ext; ?></option>
		<?php endforeach; ?>
	</select>
	<small><?php el3('Comma separated list of permitted extensions'); ?><?php el3(', Leave empty to use the global value'); ?></small>
</div>

<div class="field">
	<label><?php el3('File name provider'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][filename_provider]">
	<small><?php el3('If not empty then the resulting value will used as the file name, you can use {var:%s.file.name} and {var:%s.file.extension} to get the file name and extension.', [$unit['name'], $unit['name']]); ?></small>
</div>

<div class="two fields">
	
	<div class="field">
		<label><?php el3('Max size in KB'); ?></label>
		<input type="text" value="1000" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][size]">
	</div>
	
</div>