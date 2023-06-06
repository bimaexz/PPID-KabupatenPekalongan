<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Openning date/time'); ?></label>
		<div class="ui calendar">
			<div class="ui input icon">
				<input type="text" placeholder="YYYY-MM-DD HH:mm:ss" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][watchman][mindate]" data-calendar="1" data-dformat="YYYY-MM-DD HH:mm:ss" data-sformat="YYYY-MM-DD HH:mm:ss">
			</div>
		</div>
		<small><?php el3('The first date on which the form will be accessible'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Closing date/time'); ?></label>
		<div class="ui calendar">
			<div class="ui input icon">
				<input type="text" placeholder="YYYY-MM-DD HH:mm:ss" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][watchman][maxdate]" data-calendar="1" data-dformat="YYYY-MM-DD HH:mm:ss" data-sformat="YYYY-MM-DD HH:mm:ss">
			</div>
		</div>
		<small><?php el3('The last date on which the form will be accessible'); ?></small>
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Off Days'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][watchman][offdays][]" class="ui fluid dropdown" multiple="multiple" data-clearable="1">
			<option value="0"><?php el3('Sunday'); ?></option>
			<option value="1"><?php el3('Monday'); ?></option>
			<option value="2"><?php el3('Tuesday'); ?></option>
			<option value="3"><?php el3('Wednesday'); ?></option>
			<option value="4"><?php el3('Thursday'); ?></option>
			<option value="5"><?php el3('Friday'); ?></option>
			<option value="6"><?php el3('Saturday'); ?></option>
		</select>
		<small><?php el3('A list of the week days on which the form will NOT be accessible'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Off Hours'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][watchman][offhours][]" class="ui fluid dropdown" multiple="multiple" data-clearable="1">
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
		<small><?php el3('A list of the hours which the form will NOT be accessible'); ?></small>
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Maximum number of submissions'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][watchman][maxcount]" />
		<small><?php el3('The maximum allowed number of submissions, the DB Log behavior must be enabled'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Maximum number of submissions per user'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][watchman][usercount]" />
		<small><?php el3('The maximum allowed number of submissions per USER, the DB Log behavior must be enabled'); ?></small>
	</div>
</div>

<div class="field">
	<label><?php el3('Closed IPs'); ?></label>
	<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][watchman][ips][closed]" rows="5" data-autoresize="7"></textarea>
	<small><?php el3('Multiline list of IP addresses to be blocked'); ?></small>
</div>

<div class="field">
	<label><?php el3('Failure Page'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][watchman][page]" class="ui fluid dropdown search" data-list=".pagesList" data-allowadditions="1" data-clearable="1">
		<option value=""></option>
	</select>
	<small><?php el3('A form page to process if the user is denied access'); ?></small>
</div>