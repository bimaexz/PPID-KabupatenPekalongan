<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Type'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][type]" class="ui fluid dropdown">
			<option value="submit"><?php el3('Submit'); ?></option>
			<option value="reset"><?php el3('Reset'); ?></option>
			<option value="clear"><?php el3('Clear'); ?></option>
			<option value="button"><?php el3('Button'); ?></option>
			<!-- <option value="repeater_add"><?php el3('Repeater Add'); ?></option>
			<option value="repeater_remove"><?php el3('Repeater Remove'); ?></option> -->
			
			<!-- <option value="link"><?php el3('Link'); ?></option>
			<option value="toolbar"><?php el3('Toolbar Button'); ?></option>
			<option value="repeater_add"><?php el3('Repeater Add'); ?></option>
			<option value="repeater_remove"><?php el3('Repeater Remove'); ?></option>
			<option value="partitions_forward"><?php el3('Partitions Forward'); ?></option>
			<option value="partitions_backward"><?php el3('Partitions Backward'); ?></option>
			<option value="partitions_finish"><?php el3('Partitions Finish'); ?></option> -->
		</select>
	</div>
	
	<div class="field">
		<label><?php el3('Text'); ?></label>
		<input type="text" value="Button <?php echo $n; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][content]" class="field_label">
	</div>
</div>