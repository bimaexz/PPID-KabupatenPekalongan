<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php if($unit['type'] == 'field_textarea'): ?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Value'); ?></label>
		<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][content]" rows="1" data-autoresize="7"></textarea>
	</div>
	<div class="field">
		<label><?php el3('Placeholder'); ?></label>
		<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][placeholder]" rows="1" data-autoresize="7"></textarea>
	</div>
</div>
<?php else: ?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Value'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][value]">
		<small><?php el3('The field default value'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Placeholder'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][placeholder]">
		<small><?php el3('Placeholder text will appear in the field when the field is empty'); ?></small>
	</div>
</div>
<?php endif; ?>