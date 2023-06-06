<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Start Rating'); ?></label>
		<input type="text" value="0" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-rating]">
		<small><?php el3('The active rating value.'); ?></small>
	</div>
	
	<div class="field">
		<label><?php el3('Max rating'); ?></label>
		<input type="text" value="5" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-max-rating]">
		<small><?php el3('The maximum value for the rating.'); ?></small>
	</div>
</div>