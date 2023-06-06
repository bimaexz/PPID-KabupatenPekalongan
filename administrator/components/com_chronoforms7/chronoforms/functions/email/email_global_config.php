<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Recipients'); ?></label>
	<select name="Extension[settings][email][recipients][]" multiple="" class="ui fluid dropdown search" data-clearable="1" data-allowadditions="1">
		<option value="<?php echo \GApp3::user()->get('email'); ?>" selected="selected"><?php echo \GApp3::user()->get('email'); ?></option>
	</select>
	<small><?php el3('The default recipients list.'); ?></small>
</div>
<div class="field">
	<label><?php el3('Subject'); ?></label>
	<input type="text" name="Extension[settings][email][subject]" value="A new ChronoForm has been received!">
	<small><?php el3('The default email subject.'); ?></small>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('From name'); ?></label>
		<input type="text" name="Extension[settings][email][from_name]" value="<?php echo \G3\L\Config::get('mail.from_name'); ?>">
		<small><?php el3('The from name used by default.'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('From email'); ?></label>
		<input type="text" name="Extension[settings][email][from_email]" value="<?php echo \G3\L\Config::get('mail.from_email'); ?>">
		<small><?php el3('The from email used by default.'); ?></small>
	</div>
</div>