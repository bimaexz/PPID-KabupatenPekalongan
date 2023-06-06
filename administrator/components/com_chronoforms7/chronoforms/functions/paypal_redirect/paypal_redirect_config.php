<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui segment basic message grey tab unit-config active" data-tab="unit-<?php echo $n; ?>">
	<?php
		//if(\GApp3::extension()->valid('paypal') OR \GApp3::extension()->valid('extras')):
		if(\GApp3::extension()->valid()):
	?>
		<div class="ui message green">The PayPal function is validated, thank you.</div>
	<?php else: ?>
		<div class="ui message red">The PayPal function is in trial mode and will always redirect to the sandbox website, please validate it after testing.</div>
	<?php endif; ?>
	
	<div class="ui top attached tabular menu small G3-tabs">
		<a class="item active" data-tab="unit-<?php echo $n; ?>-basic"><?php el3('Basic'); ?></a>
	</div>
	
	<div class="ui bottom attached tab segment active" data-tab="unit-<?php echo $n; ?>-basic">
		
		<div class="ui segment active" data-tab="unit-<?php echo $n; ?>">
		
			<div class="three fields">
				<div class="field">
					<label><?php el3('Payment type'); ?></label>
					<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][cmd]" class="ui fluid dropdown">
						<option value="_cart"><?php el3('Shopping cart'); ?></option>
						<option value="_ext-enterd"><?php el3('Single checkout'); ?></option>
						<?php /*<option value="_xclick-subscriptions"><?php el3('Recurring payment'); ?></option>*/ ?>
					</select>
				</div>
				<div class="field required">
					<label><?php el3('Business email'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][business]">
				</div>
				<div class="field">
					<label><?php el3('Mode'); ?></label>
					<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][sandbox]" class="ui fluid dropdown">
						<option value="0"><?php el3('Live'); ?></option>
						<option value="1"><?php el3('Sandbox testing'); ?></option>
					</select>
					<small><?php el3('Select Sandbox for payment tests.'); ?></small>
				</div>
			</div>
			
			<div class="two fields">
				<div class="field">
					<label><?php el3('Currency code'); ?></label>
					<input type="text" value="USD" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][currency_code]">
				</div>
				<div class="field">
					<label><?php el3('Quantity'); ?></label>
					<input type="text" value="1" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][quantity]">
				</div>
				<div class="field">
					<label><?php el3('Debug'); ?></label>
					<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][debug]" class="ui fluid dropdown">
						<option value="0"><?php el3('Disabled'); ?></option>
						<option value="1"><?php el3('Enabled'); ?></option>
					</select>
					<small><?php el3('Display the full redirect url and do not redirect to the PayPal website.'); ?></small>
				</div>
			</div>
			
			<div class="ui header dividing"><?php el3('Items data'); ?></div>
			
			<div class="three fields">
				<div class="field">
					<label><?php el3('Item name'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][item_name]">
				</div>
				<div class="field">
					<label><?php el3('Item number'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][item_number]">
				</div>
				<div class="field">
					<label><?php el3('Amount'); ?></label>
					<input type="text" value="1" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][amount]">
				</div>
			</div>
			
			<div class="three fields">
				<div class="field">
					<label><?php el3('Shipping costs'); ?></label>
					<input type="text" value="0" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][shipping]">
				</div>
				<div class="field">
					<label><?php el3('2nd item shipping costs'); ?></label>
					<input type="text" value="0" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][shipping2]">
				</div>
				<div class="field">
					<label><?php el3('Handling'); ?></label>
					<input type="text" value="0" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][handling]">
				</div>
			</div>
			
			<div class="ui header dividing"><?php el3('Extra settings'); ?></div>
			
			<div class="three fields">
				<div class="field">
					<label><?php el3('No shipping address'); ?></label>
					<input type="text" value="0" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][no_shipping]">
				</div>
				<div class="field">
					<label><?php el3('No note field'); ?></label>
					<input type="text" value="0" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][no_note]">
				</div>
				<div class="field">
					<label><?php el3('Note field label'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][cn]">
				</div>
			</div>
			
			<div class="two fields">
				<div class="field">
					<label><?php el3('Return url after completion'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][return]">
					<small><?php el3('User full url or {url.full:event}'); ?></small>
				</div>
				<div class="field">
					<label><?php el3('Return url after Cancel'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][cancel_return]">
					<small><?php el3('User full url or {url.full:event}'); ?></small>
				</div>
			</div>
			
			<div class="field">
				<label><?php el3('IPN notify URL'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][notify_url]">
				<small><?php el3('User full url or {url.full:event}'); ?></small>
			</div>
			
			<div class="field">
				<label><?php el3('Logo Image URL'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][image_url]">
			</div>
			
			
			<div class="three fields">
				<div class="field">
					<label><?php el3('Custom parameter'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][custom]">
				</div>
				<div class="field">
					<label><?php el3('Invoice#'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][invoice]">
				</div>
				<div class="field">
					<label><?php el3('Tax amount'); ?></label>
					<input type="text" value="0" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][tax]">
				</div>
			</div>
			
			<div class="ui header dividing"><?php el3('Customer info'); ?></div>
			
			<div class="three fields">
				<div class="field">
					<label><?php el3('Email'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][email]">
				</div>
				<div class="field">
					<label><?php el3('First name'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][first_name]">
				</div>
				<div class="field">
					<label><?php el3('Last name'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][last_name]">
				</div>
			</div>
			
			<div class="three fields">
				<div class="field">
					<label><?php el3('Address 1'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][address1]">
				</div>
				<div class="field">
					<label><?php el3('Address 2'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][address2]">
				</div>
				<div class="field">
					<label><?php el3('City'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][city]">
				</div>
			</div>
			
			<div class="three fields">
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
					<small><?php el3('2 characters country code or a provider shortcode.'); ?></small>
				</div>
			</div>
			
			<div class="three fields">
				<div class="field">
					<label><?php el3('Locale'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][lc]">
					<small><?php el3('2 characters language code or a provider shortcode.'); ?></small>
				</div>
			</div>
			
			<div class="ui header dividing"><?php el3('Options'); ?></div>
			
			<div class="two fields">
				<div class="field">
					<label><?php el3('Option 1 name'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][on0]">
				</div>
				<div class="field">
					<label><?php el3('Option 1 value'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][os0]">
				</div>
			</div>
			
			<div class="two fields">
				<div class="field">
					<label><?php el3('Option 2 name'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][on1]">
				</div>
				<div class="field">
					<label><?php el3('Option 2 value'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][os1]">
				</div>
			</div>
			
		</div>
		
	</div>
	
</div>