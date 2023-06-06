<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui segment basic message grey tab unit-config active" data-tab="unit-<?php echo $n; ?>">
	
	<div class="ui top attached tabular menu small G3-tabs">
		<a class="item active" data-tab="unit-<?php echo $n; ?>-basic"><?php el3('Basic'); ?></a>
	</div>
	
	<div class="ui bottom attached tab segment active" data-tab="unit-<?php echo $n; ?>-basic">
		
		
		<div class="field">
			<label><?php el3('Label'); ?></label>
			<input type="text" value="Optional email address" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][label]">
			<small><?php el3('Most users will not see this label, the label will be visible only to users without CSS'); ?></small>
		</div>

		<div class="field">
			<label><?php el3('Name'); ?></label>
			<input type="text" value="email_address_<?php echo $n.'_'.rand(1000,9999); ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][params][name]">
			<small><?php el3('No spaces or special characters should be used here, copy this to your check honeypot action.'); ?></small>
		</div>
		
		<div class="field required">
			<label><?php el3('Error message'); ?></label>
			<input type="text" value="You didn't pass the honeypot test." name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][failed_error]">
			<small><?php el3('Error message to display when the test fails'); ?></small>
		</div>

		<?php $this->view($this->get('cf.paths.shared').'behaviors_list.php', ['n' => $n, 'utype' => $utype, 'unit' => $unit, 'group' => 'html']); ?>
		<?php $this->view($this->get('cf.paths.shared').'behaviors_list.php', ['n' => $n, 'utype' => $utype, 'unit' => $unit, 'group' => 'data']); ?>
		
	</div>
	
</div>