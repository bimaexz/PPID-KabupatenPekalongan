<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Menu Style'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][style]" class="ui fluid dropdown" placeholder="1">
		<option value=""><?php el3('Default'); ?></option>
		<option value="secondary"><?php el3('Secondary'); ?></option>
		<option value="pointing"><?php el3('Pointing'); ?></option>
		<option value="secondary pointing"><?php el3('Secondary Pointing'); ?></option>
		<option value="tabular"><?php el3('Tabular'); ?></option>
		<option value="text"><?php el3('Text'); ?></option>
	</select>
	<small><?php el3('Choose the menu visual style'); ?></small>
</div>