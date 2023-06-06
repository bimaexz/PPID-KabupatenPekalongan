<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Recipients'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][user_email][recipients][]" class="ui fluid dropdown search multiple" multiple="multiple" data-list=".inputsList" data-types='["field_text", "field_select", "field_radios", "field_checkboxes"]' data-allowadditions="1" data-clearable="1">
			<!-- <option value=""></option> -->
		</select>
		<small><?php el3('Select fields or enter email addresses to be used as the email recipients'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Subject'); ?></label>
		<input type="text" value="Thank you for contacting {site:title}!" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][user_email][subject]">
		<small><?php el3('The subject of the email message'); ?><?php el3(', Leave empty to use the global value'); ?></small>
	</div>
</div>

<div class="field">
	<label><?php el3('Body'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'wysiwyg_editor.php', ['n' => $n, 'editor_id' => 'user_email_editor', 'name' => 'Connection['.$utype.']['.$n.'][user_email][body]', 'content' => 
	'Thank you for contacting {site:title}! Our specialists will contact you at the soonest opportunity.
<br><br>
In the meantime, we have received the following details from you:
<br><br>
{email_content}'
, 'editor_enabled' => false]); ?>
	<small><?php el3('This is the email body content'); ?></small>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Reply Email'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][user_email][reply_email]" class="ui fluid dropdown search" data-list=".inputsList" data-types='["field_text", "field_select", "field_radios", "field_checkboxes"]' data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Select a field or enter a value to be used as the Email reply address'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Reply Name'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][user_email][reply_name]" class="ui fluid dropdown search" data-list=".inputsList" data-types='["field_text", "field_select", "field_radios", "field_checkboxes"]' data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Select a field or enter a value to be used as the Email reply name'); ?></small>
	</div>
</div>