<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Help Text'); ?></label>
		<textarea name="Connection[views][<?php echo $n; ?>][nodes][help][content]" rows="2"></textarea>
		<small><?php el3('Help text to be displayed under the field'); ?></small>
	</div>
	
	<div class="field">
		<label><?php el3('Tooltip Text'); ?></label>
		<textarea name="Connection[views][<?php echo $n; ?>][nodes][tooltip][attrs][data-hint]" rows="2"></textarea>
		<small><?php el3('Text to be displayed in a tooltip for this field'); ?></small>
	</div>
</div>