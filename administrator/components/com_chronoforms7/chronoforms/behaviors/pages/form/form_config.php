<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields inline">
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][form][absolute_url]" data-ghost="1" value="">
			<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][form][absolute_url]" value="1">
			<label><?php el3('Absolute URL'); ?></label>
			<small><?php el3('Submit to the the Chronoforms page instead of the current page'); ?></small>
		</div>
	</div>
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][form][nodes][main][attrs][class][ajax]" data-ghost="1" value="">
			<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][form][nodes][main][attrs][class][ajax]" value="G3-dynamic">
			<label><?php el3('AJAX Form'); ?></label>
			<small><?php el3('Submit the form using AJAX without reloading the page'); ?></small>
		</div>
	</div>
</div>