<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Unit'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][inherits]" class="ui fluid dropdown" data-list=".viewsList" data-types='["<?php echo $unit['type']; ?>"]' data-keepnonexistent="1" data-clearable="1">
		<option value=""></option>
	</select>
	<small><?php el3('Select a unit to copy settings from'); ?></small>
</div>