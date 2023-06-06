<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui segment basic message grey tab unit-config active" data-tab="unit-<?php echo $n; ?>">
	
	<div class="ui top attached tabular menu small G3-tabs">
		<a class="item active" data-tab="unit-<?php echo $n; ?>-basic"><?php el3('Basic'); ?></a>
	</div>
	
	<div class="ui bottom attached tab segment active" data-tab="unit-<?php echo $n; ?>-basic">
		
<!-- 		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Data provider'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][data_provider]">
				<small><?php el3('Optional data provider'); ?></small>
			</div>
			
		</div> -->
		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Style'); ?></label>
				<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][style]" class="ui fluid dropdown">
					<option value="tabular menu"><?php el3('Tabular menu'); ?></option>
					<option value="vertical tabular menu"><?php el3('Vertical Tabular menu'); ?></option>
					<option value="menu"><?php el3('Primary Menu'); ?></option>
					<option value="secondary menu"><?php el3('Secondary Menu'); ?></option>
					<option value="pointing menu"><?php el3('Pointing Menu'); ?></option>
					<option value="secondary pointing menu"><?php el3('Secondary Pointing Menu'); ?></option>
					<option value="text menu"><?php el3('Text menu'); ?></option>
					<option value="steps"><?php el3('Steps'); ?></option>
					<option value="vertical steps"><?php el3('Vertical Steps'); ?></option>
					<option value="sequence"><?php el3('Sequence'); ?></option>
				</select>
			</div>
			
			<div class="field">
				<label><?php el3('Sequential'); ?></label>
				<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][sequential]" class="ui fluid dropdown">
					<option value="0"><?php el3('No'); ?></option>
					<option value="1"><?php el3('Yes'); ?></option>
				</select>
				<small class="field-desc"><?php el3('If enabled, partitions will be disabled until the previous ones have been completed.', [], 'sequential partition desc'); ?></small>
			</div>
		</div>
		
		<!-- <div class="equal width fields">
			<?php $this->view($this->get('cf.paths.shared').'size_dropdown.php', ['n' => $n]); ?>
			
			<?php $this->view($this->get('cf.paths.shared').'color_dropdown.php', ['utype' => $utype, 'n' => $n]); ?>
			
			<div class="field">
				<label><?php el3('Attached style'); ?></label>
				<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][attached]" class="ui fluid dropdown">
					<option value="top attached"><?php el3('Top attached'); ?></option>
					<option value=""><?php el3('Not attached'); ?></option>
				</select>
				<small><?php el3('Affects how the navigation list appears'); ?></small>
			</div>
		</div> -->
		
		<div class="field">
			<label><?php el3('Partitions list'); ?></label>
			
			<?php $this->view(dirname(__FILE__).DS.'partitions_config.php', ['unit' => $unit, 'utype' => $utype, 'n' => $n]); ?>
		</div>
		
		<?php $this->view($this->get('cf.paths.shared').'refresh_button.php'); ?>

		<?php $this->view($this->get('cf.paths.shared').'behaviors_list.php', ['n' => $n, 'utype' => $utype, 'unit' => $unit, 'group' => 'html']); ?>
		<?php $this->view($this->get('cf.paths.shared').'behaviors_list.php', ['n' => $n, 'utype' => $utype, 'unit' => $unit, 'group' => 'data']); ?>
		
	</div>
	
</div>