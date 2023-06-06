<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Type'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][type]" class="ui fluid dropdown">
			<option value="date"><?php el3('Date'); ?></option>
			<option value="time"><?php el3('Time'); ?></option>
			<option value="datetime"><?php el3('DateTime'); ?></option>
			<option value="month"><?php el3('Month'); ?></option>
			<option value="year"><?php el3('Year'); ?></option>
		</select>
	</div>
	
	<div class="field">
		<label><?php el3('Start mode'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][startmode]" class="ui fluid dropdown">
			<option value="day"><?php el3('Day'); ?></option>
			<option value="month"><?php el3('Month'); ?></option>
			<option value="year"><?php el3('Year'); ?></option>
			<option value="hour"><?php el3('Hour'); ?></option>
			<option value="minute"><?php el3('Minute'); ?></option>
		</select>
	</div>
</div>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Start day'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][firstday]" class="ui fluid dropdown">
			<option value="0"><?php el3('Sunday'); ?></option>
			<option value="1"><?php el3('Monday'); ?></option>
			<option value="2"><?php el3('Tuesday'); ?></option>
			<option value="3"><?php el3('Wednesday'); ?></option>
			<option value="4"><?php el3('Thursday'); ?></option>
			<option value="5"><?php el3('Friday'); ?></option>
			<option value="6"><?php el3('Saturday'); ?></option>
		</select>
	</div>

	<div class="field">
		<label><?php el3('Display Mode'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][inline]" class="ui fluid dropdown">
			<option value="0"><?php el3('Popup calendar'); ?></option>
			<!-- <option value="1"><?php el3('Inline with field'); ?></option> -->
			<option value="2"><?php el3('Inline without field'); ?></option>
		</select>
		<small><?php el3('How the calendar is displayed on the page.'); ?></small>
	</div>
</div>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Display Format'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][dformat]" class="ui fluid search dropdown" data-allowadditions="1">
			<option value="YYYY-MM-DD HH:mm:ss">YYYY-MM-DD HH:mm:ss</option>
			<option value="HH:mm:ss">HH:mm:ss</option>
			<option value="DD/MM/YYYY">DD/MM/YYYY</option>
		</select>
		<small><?php el3('The displayed date format.'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Real Format'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][sformat]" class="ui fluid search dropdown" data-allowadditions="1">
			<option value="YYYY-MM-DD HH:mm:ss">YYYY-MM-DD HH:mm:ss</option>
			<option value="HH:mm:ss">HH:mm:ss</option>
			<option value="DD/MM/YYYY">DD/MM/YYYY</option>
		</select>
		<small><?php el3('The stored date format, it is recommended to keep this in mysql datettime format'); ?></small>
	</div>
</div>