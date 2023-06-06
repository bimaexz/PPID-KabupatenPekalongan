<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Width'); ?></label>
	<select name="Connection[views][<?php echo $n; ?>][nodes][container][attrs][class][width]" class="ui fluid dropdown" data-clearable="1">
		<option value=""><?php el3('Auto'); ?></option>
		<option value="two wide"><?php echo '2/16'; ?></option>
		<option value="three wide"><?php echo '3/16'; ?></option>
		<option value="four wide"><?php echo '4/16'; ?></option>
		<option value="five wide"><?php echo '5/16'; ?></option>
		<option value="six wide"><?php echo '6/16'; ?></option>
		<option value="seven wide"><?php echo '7/16'; ?></option>
		<option value="eight wide"><?php echo '8/16'; ?></option>
		<option value="nine wide"><?php echo '9/16'; ?></option>
		<option value="ten wide"><?php echo '10/16'; ?></option>
		<option value="eleven wide"><?php echo '11/16'; ?></option>
		<option value="twelve wide"><?php echo '12/16'; ?></option>
		<option value="thirteen wide"><?php echo '13/16'; ?></option>
		<option value="fourteen wide"><?php echo '14/16'; ?></option>
		<option value="fifteen wide"><?php echo '15/16'; ?></option>
	</select>
	<small><?php el3('The width of the field in 16 columns grid'); ?></small>
</div>