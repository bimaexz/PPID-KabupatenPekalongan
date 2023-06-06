<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui segment basic message grey tab unit-config active" data-tab="unit-<?php echo $n; ?>">

	<div class="ui top attached tabular menu small G3-tabs">
		<a class="item active" data-tab="unit-<?php echo $n; ?>-basic"><?php el3('Basic'); ?></a>
	</div>
	
	<div class="ui bottom attached tab segment active" data-tab="unit-<?php echo $n; ?>-basic">
		<div class="ui message">
			<?php el3('This is just a paceholder for a non existing form unit'); ?>
		</div>
		
		<div class="field">
			<label><?php el3('Unit Settings'); ?></label>
			<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][settings]" rows="20"><?php echo json_encode($unit); ?></textarea>
		</div>
		
	</div>
	
</div>