<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Data Sources'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'data_sources.php', ['unit' => $unit, 'n' => $n, 'utype' => $utype]); ?>
	<small><?php el3('The source(s) of the data list'); ?></small>
</div>
<div class="equal width fields">
	<!-- <div class="field">
		<label><?php el3('Index Name'); ?></label>
		<input type="text" value="<?php echo $unit['name']; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][index_name]" />
		<small><?php el3('the repeater index is replaced by the loop index number'); ?></small>
	</div> -->
</div>