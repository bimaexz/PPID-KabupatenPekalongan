<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<!-- <div class="ui horizontal divider"><?php el3('Shipping information'); ?></div> -->

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Name'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][ship_name]">
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Street address 1'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][ship_street_address]">
	</div>
	<div class="field">
		<label><?php el3('Street address 2'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][ship_street_address2]">
	</div>
	<div class="field">
		<label><?php el3('City'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][ship_city]">
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('State'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][ship_state]">
	</div>
	<div class="field">
		<label><?php el3('Zip'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][ship_zip]">
	</div>
	<div class="field">
		<label><?php el3('Country'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][ship_country]">
	</div>
</div>