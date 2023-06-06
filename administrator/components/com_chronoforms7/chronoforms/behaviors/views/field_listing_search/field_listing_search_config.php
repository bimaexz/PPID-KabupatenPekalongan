<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Data Source'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][units][search_list][uid]" class="ui fluid dropdown search" data-list=".functionsList" data-types='["read_data"]' data-keepnonexistent="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Select which unit will be searched by this field'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Searchable Fields'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][units][search_list][settings][models][data][search][<?php echo $n; ?>][fields][]" class="ui fluid dropdown search multiple" multiple="multiple" data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Insert the Model fields to be searchable by this field'); ?></small>
	</div>
</div>