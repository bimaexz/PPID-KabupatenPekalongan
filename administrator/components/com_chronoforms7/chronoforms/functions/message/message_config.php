<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Type'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][message_type]" class="ui fluid dropdown">
			<option value="success"><?php el3('Success'); ?></option>
			<option value="error"><?php el3('Error'); ?></option>
			<option value="info"><?php el3('Information'); ?></option>
			<option value="warning"><?php el3('Warning'); ?></option>
		</select>
	</div>
	<!-- <div class="field">
		<label><?php el3('Position'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][location]" class="ui fluid dropdown" data-clearable="1">
			<option value=""><?php el3('System messages bar'); ?></option>
			<option value="body"><?php el3('Action position'); ?></option>
		</select>
	</div> -->
</div>

<div class="field required">
	<label><?php el3('Content'); ?></label>
	<textarea rows="5" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][content]"></textarea>
</div>