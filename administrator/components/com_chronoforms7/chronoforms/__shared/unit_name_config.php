<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($this->data['Connection'][$utype][$n]['label'])){
		$this->data['Connection'][$utype][$n]['designer_label'] = $this->data['Connection'][$utype][$n]['label'];
	}
?>
<div class="ui message" style="margin-top:10px;">
	<?php //if($utype == 'functions'): ?>
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][enabled]" data-ghost="1" value="">
			<input type="checkbox" checked="checked" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][enabled]" value="1">
			<label><?php el3('Enabled'); ?></label>
			<small><?php el3('Enable or disable this unit'); ?></small>
		</div>
	</div>
	<?php //endif; ?>
	<div class="equal width fields">
		<div class="field">
			<label><?php el3('Name'); ?></label>
			<input type="text" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][name]" class="dragged-name">
			<small><?php el3('The name should be unique'); ?></small>
		</div>
	</div>
	<?php if($utype == 'functions'): ?>
	<div class="field">
		<label><?php el3('Designer label'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][designer_label]">
		<small><?php el3('A label text for this item in the form designer'); ?></small>
	</div>
	<?php endif; ?>
</div>