<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<!-- <div class="field">
		<label><?php el3('Enable Ghost'); ?></label>
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][ghost][enabled]" data-ghost="1" value="0">
			<input type="checkbox" checked="checked" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][ghost][enabled]" value="1">
			<label><?php el3('Ghost enabled'); ?></label>
			<small><?php el3('Some fields will not be set if they are not used on the form, in this case the ghost provides a default value.'); ?></small>
		</div>
	</div> -->
	<div class="field">
		<label><?php el3('Ghost value'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][ghost][value]">
		<small><?php el3('The default value to be used when the field had no selections made'); ?></small>
	</div>
</div>