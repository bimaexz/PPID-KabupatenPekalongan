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
			
			<div class="field required">
				<label><?php el3('Secret key'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][secret_key]">
				<small><?php el3('This key is required and can be acquired from Google.'); ?></small>
			</div>
			
			<div class="field">
				<label><?php el3('Error message'); ?></label>
				<input type="text" value="You didn't pass the NoCaptcha verification." name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][failed_error]">
				<small><?php el3('If the check fails, this message will be displayed.'); ?></small>
			</div>
			
		</div>
		
	</div>
	
</div>