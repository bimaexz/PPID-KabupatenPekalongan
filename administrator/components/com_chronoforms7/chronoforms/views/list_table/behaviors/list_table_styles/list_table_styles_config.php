<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Appearance'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][basic]" class="ui fluid dropdown" data-clearable="1">
			<option value=""></option>
			<option value="basic"><?php el3('Basic'); ?></option>
			<option value="very basic"><?php el3('Very Basic - Borderless'); ?></option>
		</select>
		<small><?php el3('Affects the table header background color and table borders'); ?></small>
	</div>

	<div class="field">
		<label><?php el3('Padding'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][padding]" class="ui fluid dropdown" placeholder="">
			<option value=""><?php el3('Normal'); ?></option>
			<option value="compact"><?php el3('Compact'); ?></option>
			<option value="very compact"><?php el3('Very Compact'); ?></option>
			<option value="padded"><?php el3('Padded'); ?></option>
			<option value="very padded"><?php el3('Very padded'); ?></option>
		</select>
		<small><?php el3('Affects the table cell padding'); ?></small>
	</div>
</div>
<div class="field">
	<label><?php el3('More Styles'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][others][]" multiple="multiple" class="ui fluid dropdown" placeholder="">
		<option value="celled"><?php el3('Celled'); ?></option>
		<option value="single line"><?php el3('Single Line'); ?></option>
		<option value="fixed"><?php el3('Fixed'); ?></option>
		<option value="selectable"><?php el3('Selectable'); ?></option>
		<option value="striped"><?php el3('Striped'); ?></option>
		<option value="unstackable"><?php el3('UnStackable'); ?></option>
		<option value="definition"><?php el3('Definition'); ?></option>
	</select>
	<small><?php el3('Affects the table general styling'); ?></small>
</div>