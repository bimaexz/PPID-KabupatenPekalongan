<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php if(!empty($unit['info']['config']['basics'])): ?>
<?php
	$checked = 'checked="checked"';
	if(isset($unit['nodes']['label']['content']) AND isset($unit['nodes']['main']['attrs']['name'])){
		$_name = preg_replace('/[^\w \.\#]+/', '', $unit['nodes']['label']['content']);
		$_name = preg_replace('/ +/', '_', $_name);
		$_name = strtolower($_name);
		if($_name != $unit['nodes']['main']['attrs']['name']){
			$checked = '';
		}
	}
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Label'); ?></label>
		<input type="text" value="<?php echo $unit['info']['config']['basics']['label'] ?? $unit['info']['title'].' '.$n; ?>" name="Connection[views][<?php echo $n; ?>][nodes][label][content]" class="field_label">
	</div>
	<div class="field">
		<label><?php el3('Field Name'); ?>
		</label>
		<input type="text" value="<?php echo \G3\L\Str::slug($unit['info']['title'], '_'); ?>_<?php echo $n; ?>" name="Connection[views][<?php echo $n; ?>][nodes][main][attrs][name]" class="field_param_name">
		<div class="ui checkbox" style="margin-top:0;">
			<input type="checkbox" <?php echo $checked; ?> class="hidden field_param_name_auto">
			<label><small><?php el3('Auto create from Label text'); ?></small></label>
		</div>
	</div>
</div>
<?php endif; ?>