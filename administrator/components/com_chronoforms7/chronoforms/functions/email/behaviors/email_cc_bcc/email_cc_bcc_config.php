<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('CC Addresses'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][cc][]" class="ui fluid dropdown search multiple" data-list=".inputsList" data-types='["field_text", "field_select", "field_radios", "field_checkboxes"]' data-allowadditions="1" multiple="multiple">
			<option value=""></option>
		</select>
		<small><?php el3('Select or enter the CC addresses'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('BCC Addresses'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][bcc][]" class="ui fluid dropdown search multiple" data-list=".inputsList" data-types='["field_text", "field_select", "field_radios", "field_checkboxes"]' data-allowadditions="1" multiple="multiple">
			<option value=""></option>
		</select>
		<small><?php el3('Select or enter the BCC addresses'); ?></small>
	</div>
</div>