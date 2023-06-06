<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Open days'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][opendays][]" class="ui fluid dropdown" multiple="multiple" data-clearable="1">
			<option value="0"><?php el3('Sunday'); ?></option>
			<option value="1"><?php el3('Monday'); ?></option>
			<option value="2"><?php el3('Tuesday'); ?></option>
			<option value="3"><?php el3('Wednesday'); ?></option>
			<option value="4"><?php el3('Thursday'); ?></option>
			<option value="5"><?php el3('Friday'); ?></option>
			<option value="6"><?php el3('Saturday'); ?></option>
		</select>
		<small><?php el3('A list of the week days on which the date can be selected, leave empty to have all weekdays available'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Open hours'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][openhours][]" class="ui fluid dropdown" multiple="multiple" data-clearable="1">
			<option value="0"><?php el3('00:00'); ?></option>
			<option value="1"><?php el3('01:00'); ?></option>
			<option value="2"><?php el3('02:00'); ?></option>
			<option value="3"><?php el3('03:00'); ?></option>
			<option value="4"><?php el3('04:00'); ?></option>
			<option value="5"><?php el3('05:00'); ?></option>
			<option value="6"><?php el3('06:00'); ?></option>
			<option value="7"><?php el3('07:00'); ?></option>
			<option value="8"><?php el3('08:00'); ?></option>
			<option value="9"><?php el3('09:00'); ?></option>
			<option value="10"><?php el3('10:00'); ?></option>
			<option value="11"><?php el3('11:00'); ?></option>
			<option value="12"><?php el3('12:00'); ?></option>
			<option value="13"><?php el3('13:00'); ?></option>
			<option value="14"><?php el3('14:00'); ?></option>
			<option value="15"><?php el3('15:00'); ?></option>
			<option value="16"><?php el3('16:00'); ?></option>
			<option value="17"><?php el3('17:00'); ?></option>
			<option value="18"><?php el3('18:00'); ?></option>
			<option value="19"><?php el3('19:00'); ?></option>
			<option value="20"><?php el3('20:00'); ?></option>
			<option value="21"><?php el3('21:00'); ?></option>
			<option value="22"><?php el3('22:00'); ?></option>
			<option value="23"><?php el3('23:00'); ?></option>
		</select>
		<small><?php el3('A list of the hours on which the time can be selected, leave empty to have all hours available'); ?></small>
	</div>
</div>