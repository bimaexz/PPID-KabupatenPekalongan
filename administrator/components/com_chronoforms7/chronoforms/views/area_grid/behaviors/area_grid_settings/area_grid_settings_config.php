<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Stackable'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][stackable]" class="ui fluid dropdown" data-clearable="1">
			<option value=""><?php el3('No'); ?></option>
			<option value="stackable"><?php el3('Yes'); ?></option>
		</select>
		<small><?php el3('Should the grid columns stack over each other on smaller screens'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Dividers'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][divided]" class="ui fluid dropdown" data-clearable="1">
			<option value=""><?php el3('None'); ?></option>
			<option value="divided"><?php el3('Columns dividers'); ?></option>
			<option value="vertically divided"><?php el3('Rows dividers'); ?></option>
		</select>
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Celled'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][celled]" class="ui fluid dropdown" data-clearable="1">
			<option value=""><?php el3('None'); ?></option>
			<option value="celled"><?php el3('Full cells'); ?></option>
			<option value="internally celled"><?php el3('Internally celled'); ?></option>
		</select>
	</div>
	<div class="field">
		<label><?php el3('Padding'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][padded]" class="ui fluid dropdown" data-clearable="1">
			<option value=""><?php el3('None'); ?></option>
			<option value="vertically padded"><?php el3('Vertically padded'); ?></option>
			<option value="horizontally padded"><?php el3('Horizontally padded'); ?></option>
			<option value="relaxed"><?php el3('Relaxed'); ?></option>
		</select>
	</div>
</div>