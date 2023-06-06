<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Recipients list'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][recipients][]" multiple="multiple" class="ui fluid dropdown search" data-clearable="1" data-allowadditions="1" data-list=".inputsList" data-types='["field_text", "field_select", "field_radios", "field_checkboxes"]'>
		<option value="<?php echo \GApp3::user()->get('email'); ?>" selected="selected"><?php echo \GApp3::user()->get('email'); ?></option>
	</select>
	<small><?php el3('List of email addresses separated by comma'); ?><?php el3(', Leave empty to use the global value'); ?></small>
</div>

<div class="field">
	<label><?php el3('Subject'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][subject]">
	<small><?php el3('The subject of the email message'); ?><?php el3(', Leave empty to use the global value'); ?></small>
</div>

<div class="field">
	<label><?php el3('Body'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'wysiwyg_editor.php', ['n' => $n, 'editor_id' => 'email_editor', 'name' => 'Connection[functions]['.$n.'][body]', 'editor_enabled' => false]); ?>
	<small><?php el3('Use HTML or plain text, {email_content} will be replaced by email fields data list'); ?></small>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Reply Email'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][reply_email]" class="ui fluid dropdown search" data-list=".inputsList" data-types='["field_text", "field_select", "field_radios", "field_checkboxes"]' data-allowadditions="1" data-clearable="1">
			<option value="<?php echo \GApp3::user()->get('email'); ?>"><?php echo \GApp3::user()->get('email'); ?></option>
		</select>
		<small><?php el3('Select a field or enter a value to be used as the Email reply address'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Reply Name'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][reply_name]" class="ui fluid dropdown search" data-list=".inputsList" data-types='["field_text", "field_select", "field_radios", "field_checkboxes"]' data-allowadditions="1" data-clearable="1">
			<option value="<?php echo \GApp3::user()->get('name'); ?>"><?php echo \GApp3::user()->get('name'); ?></option>
		</select>
		<small><?php el3('Select a field or enter a value to be used as the Email reply name'); ?></small>
	</div>
</div>