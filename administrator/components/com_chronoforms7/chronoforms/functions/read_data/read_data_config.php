<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field required">
		<label><?php el3('Source Table'); ?></label>
		<?php $this->view($this->get('cf.paths.shared').'models'.DS.'models_dropdown.php', ['utype' => $utype, 'n' => $n]); ?>
		<small><?php el3('The database Table used to read the data'); ?></small>
	</div>
	<div class="field required">
		<label><?php el3('Model Name'); ?></label>
		<input type="text" value="Model<?php echo $n; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][models][data][vname]" />
		<small><?php el3('The Model name (Table Alias) under which the record(s) will be returned'); ?></small>
	</div>
</div>
<div class="field">
	<label><?php el3('Select'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][models][data][select]" class="ui fluid dropdown">
		<option value="first"><?php el3('First Record'); ?></option>
		<option value="all"><?php el3('All Matching Records'); ?></option>
		<option value="count"><?php el3('Count of matching records'); ?></option>
	</select>
	<small><?php el3('The records to return'); ?></small>
</div>