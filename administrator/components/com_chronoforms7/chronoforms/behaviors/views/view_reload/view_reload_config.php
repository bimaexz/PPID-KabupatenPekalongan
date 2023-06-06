<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Reload page'); ?></label>
		<select name="Connection[views][<?php echo $n; ?>][reload][page]" class="ui fluid dropdown search" data-list=".pagesList" data-keepnonexistent="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('The form page used to reload this element when a reload event is triggered for it'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Reload Data Scope'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][reload][scope]" class="ui fluid dropdown search" data-list=".areasList" data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('AJAX sends the data of all the form fields, set a different selector to only include the inputs inside'); ?></small>
	</div>
</div>