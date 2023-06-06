<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui segment basic message grey tab unit-config active" data-tab="unit-<?php echo $n; ?>">

	<div class="ui top attached tabular menu small G3-tabs">
		<a class="item active" data-tab="unit-<?php echo $n; ?>-basic"><?php el3('Basic'); ?></a>
	</div>
	
	<div class="ui bottom attached tab segment active" data-tab="unit-<?php echo $n; ?>-basic">
		
		<div class="ui segment active" data-tab="unit-<?php echo $n; ?>">
			
			<div class="two fields">
				<div class="field">
					<label><?php el3('List errors'); ?></label>
					<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][list_errors]" class="ui fluid dropdown">
						<option value="1"><?php el3('Yes'); ?></option>
						<option value="0"><?php el3('No'); ?></option>
					</select>
				</div>
				<div class="field">
					<label><?php el3('Data provider'); ?></label>
					<input type="text" value="{data:}" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][data_provider]">
					<small><?php el3('The data set which has the fields data.'); ?></small>
				</div>
			</div>
			
			<div class="field">
				<label><?php el3('Default error message'); ?></label>
				<input type="text" value="<?php el3('Please provide all the required info.'); ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][error_message]">
				<small><?php el3('Error message displayed when the fields data is empty.'); ?></small>
			</div>
			
			<div class="field">
				<label><?php el3('Fields list selection'); ?></label>
				<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][fields_selection]" class="ui fluid dropdown">
					<option value=""><?php el3('All fields with validation rules'); ?></option>
					<option value="include"><?php el3('Only the list of fields entered below.'); ?></option>
					<option value="exclude"><?php el3('All fields with validation rules but excluding those listed below.'); ?></option>
				</select>
				<small><?php el3('Select the fields collection to be validated.'); ?></small>
			</div>
			
			<div class="field">
				<label><?php el3('Fields list'); ?></label>
				<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][fields_list]" rows="7"></textarea>
				<small><?php el3('Multiline list of fields to be included or excluded based on the setting above.'); ?></small>
			</div>
			
		</div>
		
	</div>
	
</div>