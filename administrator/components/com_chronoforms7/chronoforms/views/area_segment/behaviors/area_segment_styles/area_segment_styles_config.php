<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Style'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][style]" class="ui fluid dropdown" data-clearable="1">
			<option value=""></option>
			<option value="raised"><?php el3('Raised'); ?></option>
			<option value="stacked"><?php el3('Stacked'); ?></option>
			<option value="piled"><?php el3('Piled'); ?></option>
			<option value="vertical"><?php el3('Vertical'); ?></option>
		</select>
		<small><?php el3('The style affects element appearance.'); ?></small>
	</div>

	<div class="field">
		<label><?php el3('Padded'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][padded]" class="ui fluid dropdown" placeholder="">
			<option value=""><?php el3('Normal'); ?></option>
			<option value="padded"><?php el3('Padded'); ?></option>
			<option value="very padded"><?php el3('Very padded'); ?></option>
		</select>
		<small><?php el3('Affects the segment padding'); ?></small>
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Floated'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][floated]" class="ui fluid dropdown" data-clearable="1">
			<option value=""><?php el3('None'); ?></option>
			<option value="right floated"><?php el3('Right floated'); ?></option>
			<option value="left floated"><?php el3('Left floated'); ?></option>
		</select>
		<small><?php el3('Segment floating'); ?></small>
	</div>
	
	<div class="field">
		<label><?php el3('Emphasis'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][emphasis]" class="ui fluid dropdown" data-clearable="1">
			<option value=""><?php el3('None'); ?></option>
			<option value="secondary"><?php el3('Secondary'); ?></option>
			<option value="tertiary"><?php el3('Tertiary'); ?></option>
		</select>
		<small><?php el3('Emphasis style'); ?></small>
	</div>
</div>