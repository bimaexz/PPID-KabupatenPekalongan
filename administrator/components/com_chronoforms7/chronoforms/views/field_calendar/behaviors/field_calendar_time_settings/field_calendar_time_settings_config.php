<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('AM-PM format'); ?></label>
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][ampm]" data-ghost="1" value="0">
			<input type="checkbox" checked="checked" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][ampm]" value="1">
			<label><?php el3('Enable AM-PM format'); ?></label>
		</div>
	</div>
	<div class="field">
		<label><?php el3('Disable minutes'); ?></label>
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][disableminute]" data-ghost="1" value="0">
			<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][disableminute]" value="1">
			<label><?php el3('Select hours only'); ?></label>
		</div>
	</div>
</div>