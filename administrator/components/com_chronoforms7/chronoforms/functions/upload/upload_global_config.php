<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Uploads path'); ?></label>
	<input type="text" name="Extension[settings][upload][path]" value="<?php echo \G3\Globals::ext_path('chronoforms', 'front').'uploads'.DS; ?>">
	<small><?php el3('Absolute path to the uploads directory on the server, or leave empty to use the default path.'); ?></small>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('File upload extensions'); ?></label>
		<select name="Extension[settings][upload][extensions][]" multiple="" class="ui fluid dropdown search" data-clearable="1" data-allowadditions="1">
			<option value="jpg" selected="selected">jpg</option>
			<option value="jpeg" selected="selected">jpeg</option>
			<option value="png" selected="selected">png</option>
			<option value="gif" selected="selected">gif</option>
			<option value="pdf" selected="selected">pdf</option>
			<option value="txt" selected="selected">txt</option>
		</select>
		<small><?php el3('Global permitted files extensions list'); ?></small>
	</div>
	
	<div class="field">
		<label><?php el3('File upload max size'); ?></label>
		<input type="text" name="Extension[settings][upload][size]" value="1000">
		<small><?php el3('The maximum size for an uploaded file in KB.'); ?></small>
	</div>
</div>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('File upload extensions error'); ?></label>
		<input type="text" name="Extension[settings][upload][errors][extensions]" value="File extension is not permitted">
		<small><?php el3('Default incorrect file extension error'); ?></small>
	</div>
	
	<div class="field">
		<label><?php el3('File upload size error'); ?></label>
		<input type="text" name="Extension[settings][upload][errors][size]" value="File exceeded the allowed size">
		<small><?php el3('Default file size overlimit error'); ?></small>
	</div>
</div>