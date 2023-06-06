<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Data Source'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][units][filter_list][uid]" class="ui fluid dropdown search" data-list=".functionsList" data-types='["read_data"]' data-keepnonexistent="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Select which data source will be filtered by this field'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Model Field'); ?></label>
		<input type="text" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][units][filter_list][settings][models][data][filters][<?php echo $n; ?>][field]">
		<small><?php el3('The Model field to be filtered by this field'); ?></small>
	</div>
</div>