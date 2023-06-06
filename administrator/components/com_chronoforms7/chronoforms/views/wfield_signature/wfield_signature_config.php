<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<!-- <div class="field">
		<label><?php el3('Width'); ?></label>
		<input type="text" value="400" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][width]">
		<small><?php el3('The default signature pad width.'); ?></small>
	</div>
		-->
	<div class="field">
		<label><?php el3('Height'); ?></label>
		<input type="text" value="150" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][canvas][attrs][height]">
		<small><?php el3('The defualt signature pad height.'); ?></small>
	</div>
	
	<div class="field">
		<label><?php el3('Clear button text'); ?></label>
		<input type="text" value="Clear" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][clear][content]">
		<small><?php el3('The text on the clear button.'); ?></small>
	</div>
	
</div>