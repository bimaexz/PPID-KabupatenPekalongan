<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Condition'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][relation]" class="ui fluid dropdown" data-clearable="1">
			<option value=""></option>
			<option value="start"><?php el3('Start DateTime'); ?></option>
			<option value="end"><?php el3('Last DateTime'); ?></option>
		</select>
		<small><?php el3('A condition on the datetime value of this field'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Source Calendar'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][related]" class="ui fluid dropdown" data-list=".inputsList" data-types='["field_calendar"]' data-keepnonexistent="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('The Calendar unit used to provide the value of the condition'); ?></small>
	</div>
</div>