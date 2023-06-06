<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<?php if($unit['type'] != 'field_checkbox'): ?>
	<div class="field">
		<label><?php el3('Layout'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][container][attrs][class][layout]" class="ui fluid dropdown">
			<option value="grouped fields"><?php el3('Vertical'); ?></option>
			<option value="inline fields"><?php el3('Horizontal'); ?></option>
		</select>
	</div>
	<?php endif; ?>
	<div class="field">
		<label><?php el3('Style'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][checkbox][attrs][class][style]" class="ui fluid dropdown" data-clearable="1">
			<option value=""><?php el3('Default'); ?></option>
			<option value="toggle"><?php el3('Toggle switch'); ?></option>
			<option value="slider"><?php el3('Slider switch'); ?></option>
			<option value="filled"><?php el3('Filled'); ?></option>
		</select>
	</div>
</div>
<?php $this->view($this->get('cf.paths.shared').'color_dropdown.php', ['utype' => $utype, 'n' => $n, 'label' => rl3('Filled Color'), 'path' => 'checkbox.attrs.class.filledcolor']); ?>