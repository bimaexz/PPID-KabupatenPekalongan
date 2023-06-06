<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Displayed Nodes'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][items][]" class="ui fluid dropdown multiple" multiple="multiple">
			<option value="navigation"><?php el3('Navigation menu'); ?></option>
			<option value="limiter"><?php el3('List length'); ?></option>
			<option value="info"><?php el3('List information'); ?></option>
		</select>
		<small><?php el3('Choose the output elements of the paginator.'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Data Source'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][data_source]" class="ui fluid dropdown" data-list=".functionsList" data-types='["read_data"]' data-keepnonexistent="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('The source of the paginator data'); ?></small>
	</div>
</div>