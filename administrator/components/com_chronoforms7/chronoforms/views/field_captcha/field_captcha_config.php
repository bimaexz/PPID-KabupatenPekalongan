<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui segment basic message grey tab unit-config active" data-tab="unit-<?php echo $n; ?>">
	
	<div class="ui top attached tabular menu small G3-tabs">
		<a class="item active" data-tab="unit-<?php echo $n; ?>-basic"><?php el3('Basic'); ?></a>
		<a class="item" data-tab="unit-<?php echo $n; ?>-validation"><?php el3('Validation'); ?></a>
		<a class="item" data-tab="unit-<?php echo $n; ?>-advanced"><?php el3('Advanced'); ?></a>
	</div>
	
	<div class="ui bottom attached tab segment active" data-tab="unit-<?php echo $n; ?>-basic">
		
		
		<div class="equal width fields">
			<div class="twelve wide field">
				<label><?php el3('Label'); ?></label>
				<input type="text" value="Human check" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][label]">
			</div>
		</div>

		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Name'); ?></label>
				<input type="text" value="captcha" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][params][name]">
				<small><?php el3('This name must be placed in the Check captcha action settings.'); ?></small>
				<small><?php el3('No spaces or special characters should be used here.'); ?></small>
			</div>
			<div class="field">
				<label><?php el3('ID'); ?></label>
				<input type="text" value="captcha" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][params][id]">
			</div>
		</div>

		<div class="field">
			<div class="ui checkbox">
				<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][fonts]" data-ghost="1" value="">
				<input type="checkbox" checked="checked" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][fonts]" value="checked">
				<label><?php el3('Use true fonts'); ?></label>
				<small><?php el3('True fonts image looks nicer but your server must support this feature.'); ?></small>
			</div>
		</div>
		
		<div class="field">
			<div class="ui checkbox">
				<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][refresh]" data-ghost="1" value="">
				<input type="checkbox" checked="checked" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][refresh]" value="checked">
				<label><?php el3('Refresh button'); ?></label>
				<small><?php el3('Add a refresh button so that the user can get another image.'); ?></small>
			</div>
		</div>
		
	</div>
	
	<div class="ui bottom attached tab segment" data-tab="unit-<?php echo $n; ?>-validation">
		<div class="field">
			<div class="ui checkbox toggle red">
				<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][validation][required]" data-ghost="1" value="">
				<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][validation][required]" value="true">
				<label><?php el3('Required ?'); ?></label>
			</div>
		</div>
		<div class="field">
			<label><?php el3('Error message'); ?></label>
			<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][verror]">
			<small><?php el3('The error message to be displayed when the field fails the validation test.'); ?></small>
		</div>
		<div class="field">
			<label><?php el3('Validation rules'); ?></label>
			<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][validation][rules]" rows="3"></textarea>
		</div>
	</div>
	
	<div class="ui bottom attached tab segment" data-tab="unit-<?php echo $n; ?>-advanced">
		
		<div class="field">
			<label><?php el3('Extra attributes'); ?></label>
			<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][attrs]" rows="3"></textarea>
		</div>
		
		<div class="field">
			<label><?php el3('Description'); ?></label>
			<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][description][text]" rows="3"></textarea>
		</div>

		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Container class'); ?></label>
				<input type="text" value="field" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][container][class]">
			</div>
		</div>
		
	</div>
	
</div>