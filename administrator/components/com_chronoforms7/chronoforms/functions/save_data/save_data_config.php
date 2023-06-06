<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field required">
		<label><?php el3('Target Table'); ?></label>
		<?php $this->view($this->get('cf.paths.shared').'models'.DS.'models_dropdown.php', ['utype' => $utype, 'n' => $n]); ?>
		<small><?php el3('Select which database Table will be used to save the data'); ?></small>
	</div>
	<div class="field required">
		<label><?php el3('Model Name'); ?></label>
		<input type="text" value="Model<?php echo $n; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][models][data][vname]" />
		<small><?php el3('The model name used in building tables relations'); ?></small>
	</div>
</div>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Action'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][models][data][action]" class="ui fluid dropdown">
			<option value="insert"><?php el3('Insert new Record'); ?></option>	
			<!-- <option value="save"><?php el3('Auto (Based on PKey value)'); ?></option> -->
			<option value="update"><?php el3('Update existing Record'); ?></option>
			<option value="insert:update"><?php el3('Insert, if duplicate Update'); ?></option>
			<option value="insert:ignore"><?php el3('Insert, if duplicate Ignore'); ?></option>
		</select>
		<small><?php el3('The save action to apply'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Data Sets'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][models][data][sets][]" multiple="multiple" class="ui fluid dropdown multiple search" data-allowadditions="1">
			<option value="{data:}" selected="selected"><?php el3('Whole Form Data'); ?></option>
		</select>
		<small><?php el3('The default data sets to be used for the inserted or updated record'); ?></small>
	</div>
</div>
<!-- <div class="equal width fields inline">
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][events][success][name]" value="success">
			<label><?php el3('Listen to Success Event'); ?></label>
			<small><?php el3('Enable the Success Event Listener'); ?></small>
		</div>
	</div>
</div> -->