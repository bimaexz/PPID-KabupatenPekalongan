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
			<div class="field">
				<label><?php el3('Label'); ?></label>
				<input type="text" value="Text label" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][label]">
			</div>
			<div class="field">
				<label><?php el3('Placeholder'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][params][placeholder]">
			</div>
		</div>

		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Name'); ?></label>
				<input type="text" value="text<?php echo $n; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][params][name]">
			</div>
			<div class="field">
				<label><?php el3('ID'); ?></label>
				<input type="text" value="text<?php echo $n; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][params][id]">
			</div>
		</div>

		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Value'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][params][value]">
			</div>
		</div>
		
	</div>
	
	<div class="ui bottom attached tab segment" data-tab="unit-<?php echo $n; ?>-validation">
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