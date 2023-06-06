<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Value'); ?></label>
		<input type="text" value="10" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-value]">
		<small><?php el3('The starting progress value'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Total'); ?></label>
		<input type="text" value="100" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-total]">
		<small><?php el3('The total progress value'); ?></small>
	</div>
</div>
<div class="field">
	<label><?php el3('Text'); ?></label>
	<input type="text" value="10%" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][progress][content]">
	<small><?php el3('The progress text'); ?></small>
</div>