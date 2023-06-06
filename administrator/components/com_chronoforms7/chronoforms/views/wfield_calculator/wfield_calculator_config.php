<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui segment basic message grey tab unit-config active" data-tab="unit-<?php echo $n; ?>">
	
	<div class="ui top attached tabular menu small G3-tabs">
		<a class="item active" data-tab="unit-<?php echo $n; ?>-basic"><?php el3('Basic'); ?></a>
	</div>
	
	<div class="ui bottom attached tab segment active" data-tab="unit-<?php echo $n; ?>-basic">
		
		
		<div class="equal width fields">
			
			<div class="field">
				<label><?php el3('Field name'); ?></label>
				<input type="text" value="total<?php echo $n; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][params][name]">
				<small><?php el3('The name of the hidden field used to store the calculated value.'); ?></small>
			</div>
			
			<div class="field">
				<label><?php el3('Field ID'); ?></label>
				<input type="text" value="total<?php echo $n; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][params][id]">
				<small><?php el3('The id of the hidden field used to store the calculated value.'); ?></small>
			</div>
			
		</div>
		
		<div class="equal width fields">
			<div class="six wide field">
				<label><?php el3('Widget ID'); ?></label>
				<input type="text" value="widget_calculator<?php echo $n; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][id]">
				<small><?php el3('an ID for the whole widget pane.'); ?></small>
			</div>
			
			<div class="ten wide field">
				<label><?php el3('Class'); ?></label>
				<input type="text" value="ui statistic" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][class]">
				<small><?php el3('The styling class.'); ?></small>
			</div>
		</div>
		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Before value'); ?></label>
				<input type="text" value="$" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][before_value]">
				<small><?php el3('A string to display before the calculated total.'); ?></small>
			</div>
			
			<div class="field">
				<label><?php el3('Initial value'); ?></label>
				<input type="text" value="0" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][value]">
				<small><?php el3('The initial displayed total.'); ?></small>
			</div>
			
			<div class="field">
				<label><?php el3('Label'); ?></label>
				<input type="text" value="in total" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][label]">
				<small><?php el3('A label for the value.'); ?></small>
			</div>
		</div>
		
	</div>
	
</div>