<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Minimum Number'); ?></label>
		<input type="text" value="0" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-mincount]" />
		<small><?php el3('The minimum number of clones to have'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Maximum Number'); ?></label>
		<input type="text" value="99" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-maxcount]" />
		<small><?php el3('The maximum number of clones to have'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Sortable'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-sortable]" class="ui fluid dropdown" placeholder="">
			<option value=""><?php el3('No'); ?></option>
			<option value="1"><?php el3('Yes'); ?></option>
		</select>
		<small><?php el3('Enable clones sorting'); ?></small>
	</div>
</div>
<div class="field">
	<label><?php el3('Clonable View'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][clonable]" class="ui fluid dropdown" data-list=".areasList" data-keepnonexistent="1" data-clearable="1">
		<option value=""></option>
	</select>
	<small><?php el3('Optional view area to be used as the cloning element, this view should be the direct single child of the repeater'); ?></small>
</div>