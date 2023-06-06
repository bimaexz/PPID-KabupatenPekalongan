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
		<!--<a class="item" data-tab="unit-<?php echo $n; ?>-events"><?php el3('Events'); ?></a>-->
	</div>
	
	<div class="ui bottom attached tab segment active" data-tab="unit-<?php echo $n; ?>-basic">
		
		<div class="ui segment active" data-tab="unit-<?php echo $n; ?>">
		
			<div class="three fields">
				<div class="field">
					<label><?php el3('Mode'); ?></label>
					<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][sandbox]" class="ui fluid dropdown">
						<option value="0"><?php el3('Live'); ?></option>
						<option value="1"><?php el3('Sandbox testing'); ?></option>
					</select>
				</div>
			</div>
			
			<div class="field">
				<label><?php el3('Receiver email'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][receiver_email]">
				<small><?php el3('Your PayPal business email, it will be checked against the payment receiver email.'); ?></small>
			</div>
			
		</div>
		
	</div>
	
	<div class="ui bottom attached tab segment" data-tab="unit-<?php echo $n; ?>-events">
		<div class="field">
			<div class="ui checkbox">
				<input type="checkbox" checked="checked" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][eventsws][]" value="success" data-event_switcher="1">
				<label><?php el3('Enable the payment Completed event'); ?></label>
			</div>
		</div>
		
		<div class="field">
			<div class="ui checkbox">
				<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][eventsws][]" value="pending" data-event_switcher="1">
				<label><?php el3('Enable the payment Pending event'); ?></label>
			</div>
		</div>
		
		<div class="field">
			<div class="ui checkbox">
				<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][eventsws][]" value="denied" data-event_switcher="1">
				<label><?php el3('Enable the payment Denied event'); ?></label>
			</div>
		</div>
		
		<div class="field">
			<div class="ui checkbox">
				<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][eventsws][]" value="expired" data-event_switcher="1">
				<label><?php el3('Enable the payment Expired event'); ?></label>
			</div>
		</div>
		
		<div class="field">
			<div class="ui checkbox">
				<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][eventsws][]" value="failed" data-event_switcher="1">
				<label><?php el3('Enable the payment Failed event'); ?></label>
			</div>
		</div>
		
		<div class="field">
			<div class="ui checkbox">
				<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][eventsws][]" value="refunded" data-event_switcher="1">
				<label><?php el3('Enable the payment Refunded event'); ?></label>
			</div>
		</div>
		
		<div class="field">
			<div class="ui checkbox">
				<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][eventsws][]" value="reversed" data-event_switcher="1">
				<label><?php el3('Enable the payment Reversed event'); ?></label>
			</div>
		</div>
	</div>
	
</div>