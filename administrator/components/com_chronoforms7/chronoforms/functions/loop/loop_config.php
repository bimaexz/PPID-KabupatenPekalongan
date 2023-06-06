<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field required">
		<label><?php el3('Data provider'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][data_provider]">
		<small><?php el3('The loop items provider, should be an array, if an integer is provided then a range between zero and this integer will be used.'); ?></small>
	</div>
	
	<!-- <div class="field">
		<label><?php el3('Keys provider (Optional)'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][keys_provider]">
		<small><?php el3('An array if supplied then only keys included in this set will execute the loop body.'); ?></small>
	</div> -->
</div>