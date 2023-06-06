<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Tags'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][tags][]" multiple="" class="ui fluid dropdown search" data-allowadditions="1">
		<?php foreach($this->get('cf_settings.tags', []) as $tag): ?>
		<option value="<?php echo $tag; ?>"><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
	<small><?php el3('Choose which tags to assign to this form, you may also add custom tags'); ?></small>
</div>