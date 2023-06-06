<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Label'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][label][content]">
</div>

<!-- <div class="field">
	<label><?php el3('Error message'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][error]">
	<small><?php el3('Error message to display when the recaptcha check fails'); ?><?php el3(', Leave empty to use the global value'); ?></small>
</div> -->
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Version'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][gversion]" class="ui fluid dropdown" data-clearable="1">
			<option value="">v2</option>
			<option value="3">v3</option>
		</select>
	</div>
	<div class="field">
		<label><?php el3('v2 Theme'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][theme]" class="ui fluid dropdown">
			<option value="light"><?php el3('Light'); ?></option>
			<option value="dark"><?php el3('Dark'); ?></option>
		</select>
	</div>
	<div class="field">
		<label><?php el3('v2 Lang code'); ?></label>
		<input type="text" value="{language:short}" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][lang]">
	</div>
</div>