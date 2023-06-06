<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<?php $this->view($this->get('cf.paths.shared').'icon_dropdown.php', ['utype' => $utype, 'n' => $n]); ?>
	
	<?php if($unit['type'] == 'field_button'): ?>
		<div class="field">
			<label><?php el3('Icon Position'); ?></label>
			<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][labeled]" class="ui fluid dropdown" data-clearable="1">
				<option value="right labeled"><?php el3('Right'); ?></option>
				<option value="left labeled"><?php el3('Left'); ?></option>
			</select>
			<small><?php el3('Choose the icon position in the button'); ?></small>
		</div>
	<?php endif; ?>

	<?php if(in_array($unit['type'], ['field_text', 'field_password', 'field_textarea'])): ?>
		<div class="field">
			<label><?php el3('Icon Position'); ?></label>
			<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][input][attrs][class][iconpos]" class="ui fluid dropdown" data-clearable="1">
				<option value="right icon"><?php el3('Right'); ?></option>
				<option value="left icon"><?php el3('Left'); ?></option>
			</select>
			<small><?php el3('Choose the icon position in the field'); ?></small>
		</div>
	<?php endif; ?>
</div>