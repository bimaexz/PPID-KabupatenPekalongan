<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$icons = [
		'circle red',
		'circle yellow',
		'circle orange',
		'circle olive',
		'circle green',
		'circle teal',
		'circle blue',
		'circle violet',
		'circle purple',
		'circle pink',
		'circle brown',
		'circle grey',
		'circle black',
	];

	$path = !empty($path) ? $path : 'main.attrs.class.color';
	$node = implode('][', explode('.', $path));
?>
<div class="field">
	<label><?php echo (!empty($label) ? $label : rl3('Color')); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][<?php echo $node; ?>]" class="ui fluid dropdown search five column" data-clearable="1" data-rich="1">
		<option value=""><?php el3('Default'); ?></option>
		<?php foreach($icons as $icon): ?>
			<option value="<?php echo explode(' ', $icon)[1]; ?>" data-html="<span class='ui button <?php echo $icon; ?>'></span>" <?php if(!empty($selected) AND ($selected == $icon)): ?>selected="selected"<?php endif; ?>></option>
		<?php endforeach; ?>
	</select>
</div>