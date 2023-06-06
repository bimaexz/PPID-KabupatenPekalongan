<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Database Table'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][log_table][tablename]" class="ui fluid search selection dropdown" data-clearable="1" data-keepnonexistent="1" data-fulltextsearch="1">
			<option value=""><?php el3('Do NOT change this to Create a New Table or Choose an Existing table'); ?></option>
			<?php foreach($this->controller->Models->tables() as $ntable => $table): ?>
				<option value="<?php echo $ntable; ?>"><?php echo $table; ?></option>
			<?php endforeach; ?>
		</select>
		<small><?php el3('Select which Table will be used to save the data'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Default Fields'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][log_table][defaults][]" class="ui fluid search selection dropdown multiple" multiple="multiple">
			<option value="uid" selected="selected"><?php el3('Unique ID'); ?></option>
			<option value="user_id" selected="selected"><?php el3('User ID'); ?></option>
			<option value="created" selected="selected"><?php el3('Creation Date'); ?></option>
			<option value="modified" selected="selected"><?php el3('Modification Date'); ?></option>
			<option value="ipaddress"><?php el3('IP Address'); ?></option>
			<option value="page"><?php el3('Page name'); ?></option>
		</select>
		<small><?php el3('Default table columns to be included beside selected fields'); ?></small>
	</div>
</div>