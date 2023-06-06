<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('From Email'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][from_email]" class="ui fluid dropdown search" data-list=".inputsList" data-types='["field_text", "field_select", "field_radios", "field_checkboxes"]' data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Select a field or enter a value to be used as the Email from address'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('From Name'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][from_name]" class="ui fluid dropdown search" data-list=".inputsList" data-types='["field_text", "field_select", "field_radios", "field_checkboxes"]' data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Select a field or enter a value to be used as the Email from name'); ?></small>
	</div>
</div>