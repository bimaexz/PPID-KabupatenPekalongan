<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field required">
		<label><?php el3('Source Table'); ?></label>
		<?php $this->view($this->get('cf.paths.shared').'models'.DS.'models_dropdown.php', ['utype' => $utype, 'n' => $n]); ?>
		<small><?php el3('Select which database Table will be used to delete the data'); ?></small>
	</div>
	<div class="field required">
		<label><?php el3('Model Name'); ?></label>
		<input type="text" value="Model<?php echo $n; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][models][data][vname]" />
		<small><?php el3('A Table alias used in the SQL query'); ?></small>
	</div>
</div>