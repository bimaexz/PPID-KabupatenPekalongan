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
					<label><?php el3('New Block status'); ?></label>
					<input type="text" value="0" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][block_provider]">
				</div>
				<div class="field required">
					<label><?php el3('Activation code provider'); ?></label>
					<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][activation_provider]">
				</div>
			</div>
			
		</div>
		
	</div>
	
</div>