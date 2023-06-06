<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Tag'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][tag]" class="ui fluid dropdown">
			<option value="h1">H1</option>
			<option value="h2">H2</option>
			<option value="h3">H3</option>
			<option value="h4">H4</option>
			<option value="h5">H5</option>
			<option value="h6">H6</option>
		</select>
		<small><?php el3('The header element tag.'); ?></small>
	</div>
	
	<div class="field">
		<label><?php el3('Content'); ?></label>
		<input type="text" value="Some header text" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][content][content]">
		<small><?php el3('The main header text.'); ?></small>
	</div>
</div>

<!-- <div class="field">
	<label><?php el3('Sub Text'); ?></label>
	<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][subheader][content]" rows="3"></textarea>
	<small><?php el3('The text of the sub header, leave empty if you do not need a sub header.'); ?></small>
</div> -->

<!-- <div class="field">
	<div class="ui checkbox toggle">
		<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][dividing]" data-ghost="1" value="">
		<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][dividing]" value="dividing">
		<label><?php el3('Dividing'); ?></label>
		<small><?php el3('A horizontal line will be added below the header'); ?></small>
	</div>
</div> -->