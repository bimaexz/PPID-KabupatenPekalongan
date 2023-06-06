<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Minimum choices'); ?></label>
		<input type="text" value="" name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][minChecked]">
		<small><?php el3('The minimum number of selections to be made'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Maximum choices'); ?></label>
		<input type="text" value="" name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][maxChecked]">
		<small><?php el3('The maximum number of selections to be made'); ?></small>
	</div>
</div>