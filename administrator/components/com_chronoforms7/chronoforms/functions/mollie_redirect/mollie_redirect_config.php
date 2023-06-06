<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>

<div class="equal width fields">
	<div class="field required">
		<label><?php el3('Live API Key'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][api_live]">
		<small><?php el3('Your Mollie Live API key'); ?></small>
	</div>
	<div class="field required">
		<label><?php el3('Test API Key'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][api_test]">
		<small><?php el3('Your Mollie Test API key'); ?></small>
	</div>
</div>
<div class="equal width fields">
	<div class="field required">
		<label><?php el3('Profile ID'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][profile_id]">
		<small><?php el3('Your Mollie Profile ID'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Live/Test'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][live]" class="ui fluid dropdown">
			<option value="0"><?php el3('Test'); ?></option>
			<option value="1"><?php el3('Live'); ?></option>
		</select>
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


<div class="ui horizontal divider"><?php el3('Order information'); ?></div>

<div class="equal width fields">
	<div class="field required">
		<label><?php el3('Currency'); ?></label>
		<input type="text" value="EUR" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][payment][amount][currency]">
	</div>
	<div class="field required">
		<label><?php el3('Value'); ?></label>
		<input type="text" placeholder="<?php el3('e.g. 10.00'); ?>" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][payment][amount][value]">
	</div>
	<div class="field required">
		<label><?php el3('Order id'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][payment][metadata][order_id]">
	</div>
</div>

<div class="equal width fields">
	<div class="field required">
		<label><?php el3('Return URL'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][payment][redirectUrl]" class="ui fluid dropdown search" data-list=".pagesList" data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('A url on your website to return the user to after the purchase'); ?></small>
	</div>
	<div class="field required">
		<label><?php el3('WebHook URL'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][payment][webhookUrl]" class="ui fluid dropdown search" data-list=".pagesList" data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('A url on your website to have the Mollie listener action'); ?></small>
	</div>
</div>

<div class="field required">
	<label><?php el3('Description'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][payment][description]">
	<small><?php el3('Your payment description'); ?></small>
</div>