<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Update Field'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][where][field][name]" class="ui fluid dropdown search">
			<option value="id"><?php el3('User ID'); ?></option>
			<option value="activation"><?php el3('Activation Token'); ?></option>
		</select>
		<small><?php el3('Which field in the users table will be used for updating the user record?'); ?></small>
	</div>

	<div class="field">
		<label><?php el3('Update Field Value'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][where][field][value]">
	</div>
</div>

<div class="field required">
	<label><?php el3('User not exists error'); ?></label>
	<input type="text" value="<?php el3('Could not find this user account'); ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][usernotexists_error]">
	<small><?php el3('Error message displayed when a user with the provided parameters is not found.'); ?></small>
</div>