<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Number of options'); ?></label>
		<input type="text" value="5" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][number]">
	</div>
</div>

<!-- <div class="field required">
	<label><?php el3('Error message'); ?></label>
	<input type="text" value="You didn't select the correct image." name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][failed_error]">
	<small><?php el3('Error message to display when the test fails'); ?></small>
</div> -->