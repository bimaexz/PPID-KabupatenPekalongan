<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields inline">
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[views][<?php echo $n; ?>][countries][iso_value]" data-ghost="1" value="">
			<input type="checkbox" checked="checked" class="hidden" name="Connection[views][<?php echo $n; ?>][countries][iso_value]" value="1">
			<label><?php el3('ISO code for Value'); ?></label>
			<small><?php el3('Use 2 letter ISO code for Option Value'); ?></small>
		</div>
	</div>
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[views][<?php echo $n; ?>][countries][flag]" data-ghost="1" value="">
			<input type="checkbox" checked="checked" class="hidden" name="Connection[views][<?php echo $n; ?>][countries][flag]" value="1">
			<label><?php el3('Display Flags'); ?></label>
			<small><?php el3('Display countries Flags in options'); ?></small>
		</div>
	</div>
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[views][<?php echo $n; ?>][countries][locales]" data-ghost="1" value="">
			<input type="checkbox" class="hidden" name="Connection[views][<?php echo $n; ?>][countries][locales]" value="1">
			<label><?php el3('Check Locales'); ?></label>
			<small><?php el3('Try to find the country name in the locales and apply the translation if available'); ?></small>
		</div>
	</div>
</div>