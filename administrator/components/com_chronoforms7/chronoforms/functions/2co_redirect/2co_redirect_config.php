<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>

<div class="equal width fields">
	<div class="field required">
		<label><?php el3('Seller id'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][sid]">
		<small><?php el3('Your 2Checkout seller id.'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Currency code'); ?></label>
		<input type="text" value="USD" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][currency_code]">
		<small><?php el3('3 characters currency code.'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Language'); ?></label>
		<input type="text" value="EN" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][lang]">
		<small><?php el3('2 characters language code.'); ?></small>
	</div>
	<!-- <div class="field">
		<label><?php el3('Parameter set'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][mode]" class="ui fluid dropdown">
			<option value="2CO"><?php el3('2CO'); ?></option>
		</select>
	</div> -->
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Live/SandBox'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][sandbox]" class="ui fluid dropdown">
			<option value="0"><?php el3('Live'); ?></option>
			<option value="1"><?php el3('Sandbox testing'); ?></option>
		</select>
	</div>
	<div class="field">
		<label><?php el3('Demo mode'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][demo]" class="ui fluid dropdown" placeholder="">
			<option value=""><?php el3('No'); ?></option>
			<option value="Y"><?php el3('Yes'); ?></option>
		</select>
		<small><?php el3('Do NOT charge'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Debug'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][debug]" class="ui fluid dropdown">
			<option value="0"><?php el3('Disabled'); ?></option>
			<option value="1"><?php el3('Enabled'); ?></option>
		</select>
		<small><?php el3('Display the redirect url only.'); ?></small>
	</div>
</div>
<!-- <div class="two fields">
	<div class="field">
		<label><?php el3('Demo mode'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][demo]" class="ui fluid dropdown">
			<option value=""><?php el3('No'); ?></option>
			<option value="Y"><?php el3('Yes'); ?></option>
		</select>
	</div>
	<div class="field required">
		<label><?php el3('Hash key'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][hash]">
		<small><?php el3('The hash is used to secure the product id, price and quantity values from being changed, use the same hash in your your 2CO listener.'); ?></small>
	</div>
</div> -->

<div class="field required">
	<label><?php el3('Products provider'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][products_provider]">
	<small><?php el3('The products array provider, each array item is a product array which may contain the following values:'); ?></small>
	<small><?php el3('type,name,quantity,price,tangible,product_id,description,recurrence,duration,startup_fee'); ?></small>
</div>



<div class="ui horizontal divider"><?php el3('Order information'); ?></div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Merchant Order id'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][merchant_order_id]">
	</div>
	<div class="field">
		<label><?php el3('Coupon'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][coupon]">
	</div>
	<!-- <div class="field">
		<label><?php el3('PayPal Direct'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][paypal_direct]">
		<small><?php el3('Return any value to redirect users to pay using PayPal, your 2CO account must have API enabled.'); ?></small>
	</div> -->
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Approved URL'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][x_receipt_link_url]">
		<small><?php el3('A url on your website to return the user to after the purchase'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Purchase step'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][purchase_step]" class="ui fluid dropdown">
			<option value="review-cart"><?php el3('Review cart'); ?></option>
			<option value="shipping-information"><?php el3('Shipping information'); ?></option>
			<option value="shipping-method"><?php el3('Shipping method'); ?></option>
			<option value="billing-information"><?php el3('Billing information'); ?></option>
			<option value="payment-method"><?php el3('Payment method'); ?></option>
		</select>
	</div>
</div>