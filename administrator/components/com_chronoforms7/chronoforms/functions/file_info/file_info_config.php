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
				<label><?php el3('File or directory path'); ?></label>
				<input type="text" value="{path:root}" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][path]">
			</div>
			
			<div class="two fields">
				<div class="field">
					<label><?php el3('Auto selection'); ?></label>
					<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][selection]" class="ui fluid dropdown">
						<option value="0"><?php el3('Disabled - use path'); ?></option>
						<option value="last_modified"><?php el3('Last modified in directory path'); ?></option>
					</select>
				</div>
			</div>
			
		</div>
		
	</div>
	
</div>