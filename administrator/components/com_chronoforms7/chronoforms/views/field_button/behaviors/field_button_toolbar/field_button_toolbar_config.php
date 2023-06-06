<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Selections required'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-selections]" class="ui fluid dropdown">
			<option value="0"><?php el3('No'); ?></option>
			<option value="1"><?php el3('Yes'); ?></option>
		</select>
		<small><?php el3('Does this button require selections to be made ?'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Page/URL'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-url]" class="ui fluid dropdown search" data-list=".pagesList" data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Full URL or form page to send the form data to'); ?></small>
	</div>
</div>

<div class="field">
	<label><?php el3('Selections error'); ?></label>
	<input type="text" value="<?php el3('Please make a selection from the list'); ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-message]">
	<small><?php el3('The error message displayed when the button is clicked but no selections are made.'); ?></small>
</div>