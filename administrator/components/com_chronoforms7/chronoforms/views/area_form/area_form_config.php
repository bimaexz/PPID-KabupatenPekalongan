<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields inline">
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][absolute_url]" data-ghost="1" value="">
			<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][absolute_url]" value="1">
			<label><?php el3('Absolute URL'); ?></label>
			<small><?php el3('Submit to the the Chronoforms page instead of the current page'); ?></small>
		</div>
	</div>
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][ajax]" data-ghost="1" value="">
			<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][ajax]" value="G3-dynamic">
			<label><?php el3('AJAX Form'); ?></label>
			<small><?php el3('Submit the form using AJAX without reloading the page'); ?></small>
		</div>
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Submit Page/URL'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][action]" class="ui fluid dropdown search" data-list=".pagesList" data-allowadditions="1" data-clearable="1" placeholder="">
			<option value=""><?php el3('Auto'); ?></option>
		</select>
		<small><?php el3('Full URL or form page to submit the form to'); ?></small>
	</div>
	<!-- <div class="field">
		<label><?php el3('Validation messages'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-vmsgs]" class="ui fluid dropdown">
			<option value="inlinetext"><?php el3('Inline error messages'); ?></option>
			<option value="inline"><?php el3('Inline tooltips'); ?></option>
			<option value="message"><?php el3('Errors list below form'); ?></option>
		</select>
	</div> -->
</div>

<!-- <div class="field">
	<label><?php el3('Custom Submit URL'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][action]">
	<small><?php el3('Submit the form to a different URL, this will stop next pages from processing'); ?></small>
</div> -->