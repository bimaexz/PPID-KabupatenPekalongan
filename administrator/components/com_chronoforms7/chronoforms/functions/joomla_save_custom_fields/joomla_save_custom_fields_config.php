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
				<label><?php el3('Item id provider'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][itemid_provider]">
				<small><?php el3('Enter the data provider for the item id value, the item id is the id value of the main record, like the user id or article id.'); ?></small>
			</div>
			
			<div class="field required">
				<label><?php el3('Fields and Values List'); ?></label>
				<?php $this->view($this->get('cf.paths.shared').'parameters_config.php', ['unit' => $unit, 'utype' => $utype, 'n' => $n, 'name' => 'fields', 'text' => rl3('Add Custom Field'), 'name_label' => rl3('Custom field name')]); ?>
				<small><?php el3('Multi line list of field_name:value to be saved, you can get the fields names from the Joomla fields manager.'); ?></small>
			</div>
			
		</div>
		
	</div>
	
</div>