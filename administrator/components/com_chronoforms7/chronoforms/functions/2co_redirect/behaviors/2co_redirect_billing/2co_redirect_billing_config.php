<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<!-- <div class="ui horizontal divider"><?php el3('Billing information'); ?></div> -->

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Card holder name'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][card_holder_name]">
	</div>
	<div class="field">
		<label><?php el3('Email'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][email]">
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Street address 1'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][street_address]">
	</div>
	<div class="field">
		<label><?php el3('Street address 2'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][street_address2]">
	</div>
	<div class="field">
		<label><?php el3('City'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][city]">
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('State'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][state]">
	</div>
	<div class="field">
		<label><?php el3('Zip'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][zip]">
	</div>
	<div class="field">
		<label><?php el3('Country'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][country]">
	</div>
</div>

<div class="two fields">
	<div class="field">
		<label><?php el3('Phone'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][phone]">
	</div>
	<div class="field">
		<label><?php el3('Phone extension'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][phone_extension]">
	</div>
</div>