<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<div class="ui checkbox toggle red">
		<input type="hidden" name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][integer]" data-ghost="1" value="">
		<input type="checkbox" class="hidden" name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][integer]" value="true">
		<label><?php el3('Integer'); ?></label>
		<small><?php el3('The field value must be an Integer'); ?></small>
	</div>
</div>
<div class="field">
	<div class="ui checkbox toggle red">
		<input type="hidden" name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][decimal]" data-ghost="1" value="">
		<input type="checkbox" class="hidden" name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][decimal]" value="true">
		<label><?php el3('Decimal'); ?></label>
		<small><?php el3('The field value must be a Decimal value'); ?></small>
	</div>
</div>
<div class="field">
	<div class="ui checkbox toggle red">
		<input type="hidden" name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][number]" data-ghost="1" value="">
		<input type="checkbox" class="hidden" name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][number]" value="true">
		<label><?php el3('Number'); ?></label>
		<small><?php el3('The field value must be a number'); ?></small>
	</div>
</div>