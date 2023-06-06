<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$options = [
		1 => rl3('One'),
		2 => rl3('Two'),
		3 => rl3('Three'),
		4 => rl3('Four'),
		5 => rl3('Five'),
		6 => rl3('Six'),
		7 => rl3('Seven'),
		8 => rl3('Eight'),
		9 => rl3('Nine'),
		10 => rl3('Ten'),
		11 => rl3('Eleven'),
		12 => rl3('Twelve'),
		13 => rl3('Thrteen'),
		14 => rl3('Fourteen'),
	];
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Group Label Text'); ?></label>
		<input type="text" value="Fields Group" name="Connection[views][<?php echo $n; ?>][nodes][label_field][content]" class="field_label">
	</div>
	<div class="field">
		<label><?php el3('Group Label width'); ?></label>
		<select name="Connection[views][<?php echo $n; ?>][nodes][label_field][width]" class="ui fluid dropdown">
			<?php foreach($options as $k => $v): ?>		
			<option value="<?php echo $k; ?>" <?php if($k == 8): ?>selected="selected"<?php endif; ?>><?php echo $v; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="field">
	<label><?php el3('Fields Layout'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][fields_area][attrs][class][number]" class="ui fluid dropdown" placeholder="">
		<option value="equal width fields"><?php el3('Equal Width'); ?></option>
		<option value="fields"><?php el3('Horizontal'); ?></option>
		<option value="grouped fields"><?php el3('Vertical'); ?></option>
	</select>
	<small><?php el3('How the area width will be divided'); ?></small>
</div>