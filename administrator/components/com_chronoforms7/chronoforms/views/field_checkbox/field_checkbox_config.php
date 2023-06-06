<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Value'); ?></label>
		<input type="text" value="1" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][value]">
		<small><?php el3('The value sent when the checkbox is checked.'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Checked'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][checked]" class="ui fluid dropdown search" data-clearable="1" data-allowadditions="1">
			<option value=""><?php el3('No'); ?></option>
			<option value="checked"><?php el3('Checked'); ?></option>
		</select>
	</div>
</div>
