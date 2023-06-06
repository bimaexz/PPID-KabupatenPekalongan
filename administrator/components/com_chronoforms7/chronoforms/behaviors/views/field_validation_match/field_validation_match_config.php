<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Matches'); ?></label>
		<select name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][match]" class="ui fluid dropdown" data-list=".inputsList" data-keepnonexistent="1" data-clearable="1">
			<option value=""></option>
			<option value="<?php echo $n; ?>"><?php echo $n; ?></option>
		</select>
		<small><?php el3('The field value must be the same as the value of the selected field'); ?></small>
	</div>
	
	<div class="field">
		<label><?php el3('Different'); ?></label>
		<select name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][different]" class="ui fluid dropdown" data-list=".inputsList" data-keepnonexistent="1" data-clearable="1">
			<option value=""></option>
			<option value="<?php echo $n; ?>"><?php echo $n; ?></option>
		</select>
		<small><?php el3('The field value must be different of the value of the selected field'); ?></small>
	</div>
</div>