<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Text'); ?></label>
		<input type="text" value="FieldSet Title" name="Connection[views][<?php echo $n; ?>][nodes][title][content]">
	</div>
	<div class="field">
		<label><?php el3('Orientation'); ?></label>
		<select name="Connection[views][<?php echo $n; ?>][nodes][title][attrs][class][orientation]" class="ui fluid dropdown">
			<option value="left"><?php el3('Left'); ?></option>
			<option value="right"><?php el3('Right'); ?></option>
		</select>
	</div>
</div>
<div class="equal width fields">
	<?php if($unit['type'] == 'area_segment'): ?>
		<div class="field">
			<label><?php el3('Style'); ?></label>
			<select name="Connection[views][<?php echo $n; ?>][nodes][title][attrs][class][style]" class="ui fluid dropdown">
				<option value="floating"><?php el3('Floating'); ?></option>
				<option value="ribbon"><?php el3('Ribbon'); ?></option>
			</select>
		</div>
	<?php endif; ?>
	<?php $this->view($this->get('cf.paths.shared').'icon_dropdown.php', ['utype' => $utype, 'n' => $n, 'node' => 'title']); ?>
</div>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Edge Spacing'); ?></label>
		<input type="text" name="Connection[views][<?php echo $n; ?>][nodes][title][spacing]" value="0">
		<small><?php el3('Add some margin to the label position, useful for Floating style label'); ?></small>
	</div>
	<?php $this->view($this->get('cf.paths.shared').'color_dropdown.php', ['utype' => $utype, 'n' => $n, 'path' => 'title.attrs.class.color']); ?>
	<?php $this->view($this->get('cf.paths.shared').'size_dropdown.php', ['utype' => $utype, 'n' => $n, 'node' => 'title']); ?>
</div>