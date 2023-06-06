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
				<div class="field required">
					<label><?php el3('Field name'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][field_name]">
					<small><?php el3('The name of the honeypot field must be provided here.'); ?></small>
				</div>
			</div>
			
			<div class="field">
				<label><?php el3('Error message'); ?></label>
				<input type="text" value="You did not pass the honeypot test." name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][failed_error]">
			</div>
			
		</div>
		
	</div>
	
</div>