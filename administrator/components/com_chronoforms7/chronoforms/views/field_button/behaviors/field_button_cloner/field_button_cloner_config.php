<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Repeater Action'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][repeater][action]" class="ui fluid dropdown">
			<option value="add"><?php el3('Add Clone'); ?></option>
			<option value="remove"><?php el3('Delete Clone'); ?></option>
			<option value="sort"><?php el3('Sort Clone'); ?></option>
		</select>
		<small><?php el3('Remove aned Sort buttons should be inside the Loop Area'); ?></small>
	</div>

	<div class="field">
		<label><?php el3('Repeater Area'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][repeater][uid]" class="ui fluid dropdown" data-list=".viewsList" data-types='["area_repeater"]' data-keepnonexistent="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Select the repeater area to be affected by the cloner action'); ?></small>
	</div>
</div>