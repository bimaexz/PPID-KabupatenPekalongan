<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>

<div class="field required">
	<label><?php el3('Secret Key'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][key][secret]">
	<small><?php el3('Your Stripe secret key'); ?></small>
</div>
<div class="field required">
	<label><?php el3('Publishable Key'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][key][publishable]">
	<small><?php el3('Your Stripe publishable key'); ?></small>
</div>

<div class="equal width fields">
	<div class="field required">
		<label><?php el3('Success URL'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][successUrl]" class="ui fluid dropdown search" data-list=".pagesList" data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('A url on your website to return the user to after the purchase is complete'); ?></small>
	</div>
	<div class="field required">
		<label><?php el3('Cancel URL'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][cancelUrl]" class="ui fluid dropdown search" data-list=".pagesList" data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('A url on your website to return the user to after the purchase is cancelled'); ?></small>
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Redirect Button'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][redirect_button]" class="ui fluid dropdown search" data-list=".viewsList" data-types='["field_button"]' data-keepnonexistent="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Select the form button to redirect the user to Stripe for payment'); ?></small>
	</div>
	<div class="field required">
		<label><?php el3('Currency'); ?></label>
		<input type="text" value="USD" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][currency]">
		<small><?php el3('The checkout currency'); ?></small>
	</div>
</div>

<div class="field">
	<label><?php el3('Products provider'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][products_provider]" class="ui fluid dropdown search" data-list=".functionsList" data-types='["shopping_cart"]' data-allowadditions="1" data-clearable="1">
		<option value=""></option>
	</select>
	<small><?php el3('Select a shopping cart action for the products list or add your own products provider'); ?></small>
</div>
