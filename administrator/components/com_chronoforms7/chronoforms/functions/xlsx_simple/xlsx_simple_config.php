<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
			
	<!-- <div class="field required">
		<label><?php el3('Data provider'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][data_provider]">
		<small><?php el3('The source of the data to be saved, should be an array, if not provided below, array keys will be used as titles.'); ?></small>
	</div> -->
	<div class="field">
		<label><?php el3('Data Sources'); ?></label>
		<?php $this->view($this->get('cf.paths.shared').'data_sources.php', ['unit' => $unit, 'n' => $n, 'utype' => $utype]); ?>
		<small><?php el3('The source(s) of the data list'); ?></small>
	</div>
	
	
</div>

<div class="field">
	<label><?php el3('Columns'); ?></label>
	<?php $this->view(dirname(__FILE__).DS.'xlsx_simple_columns_config.php', ['unit' => $unit, 'utype' => $utype, 'n' => $n]); ?>
	<small><?php el3('Choose which fields from the data provider you want to be included as columns in the XLSX file.'); ?></small>
</div>

<div class="equal width fields">

	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][disable_titles]" data-ghost="1" value="">
			<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][disable_titles]" value="1">
			<label><?php el3('Disable header titles'); ?></label>
			<small><?php el3('If enabled then header titles will not be included in the generated files.'); ?></small>
		</div>
	</div>
	
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Storage path'); ?></label>
		<input type="text" value="{path:front}<?php echo DS.'files'.DS.'xlsx'.$n.'.xlsx'; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][file_path]">
	</div>

	<div class="field">
		<label><?php el3('Action'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][action]" class="ui fluid dropdown">
			<option value="D"><?php el3('Download'); ?></option>
			<option value="S"><?php el3('Save to disk'); ?></option>
			<option value="SD"><?php el3('Save and Download'); ?></option>
		</select>
	</div>
</div>