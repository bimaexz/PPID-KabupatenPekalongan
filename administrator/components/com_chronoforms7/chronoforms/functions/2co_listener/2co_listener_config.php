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
	<div class="field required">
		<label><?php el3('Secret word'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][secret]">
		<small><?php el3('Your 2Checkout notifications secret word.'); ?></small>
	</div>
</div>
<div class="field">
	<label><?php el3('Check Type'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][check_type]" class="ui fluid dropdown">
		<option value=""><?php el3('Webhook'); ?></option>
		<option value="return"><?php el3('Payment complete redirect'); ?></option>
	</select>
</div>