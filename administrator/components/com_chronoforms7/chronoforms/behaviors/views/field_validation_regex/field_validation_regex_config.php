<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Regular expression'); ?></label>
		<input type="text" value="" name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][regExp]">
		<small><?php el3('The field value should match this regular expression, e.g: /ChronoForms/'); ?></small>
	</div>
</div>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Contains'); ?></label>
		<input type="text" value="" name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][contains]">
		<small><?php el3('The field value should contain this string'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Does NOT Contain'); ?></label>
		<input type="text" value="" name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][doesntContain]">
		<small><?php el3('The field value should NOT contain this string'); ?></small>
	</div>
</div>