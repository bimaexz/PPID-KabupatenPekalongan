<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Attached style'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][attached]" class="ui fluid dropdown" placeholder="">
		<option value=""><?php el3('Not Attached'); ?></option>
		<option value="top attached"><?php el3('Top attached'); ?></option>
		<option value="attached"><?php el3('Middle attached'); ?></option>
		<option value="bottom attached"><?php el3('Bottom attached'); ?></option>
	</select>
	<small><?php el3('Affects the outer appearance of the element'); ?></small>
</div>