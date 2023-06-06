<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Variable value'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][variable][value]" class="ui fluid search dropdown" data-allowadditions="1" data-clearable="1">
		<option value=""><?php el3('Enter value or select one'); ?></option>
		<option value="{str:uuid}"><?php el3('UUID'); ?></option>
		<option value="{str:rand}"><?php el3('Random Number'); ?></option>
		<option value="{str:ip}"><?php el3('Client IP Address'); ?></option>
		<option value="{url.full:}"><?php el3('Full URL'); ?></option>
		<option value="{form:title}"><?php el3('Form Title'); ?></option>
		<option value="{site:title}"><?php el3('WebSite Title'); ?></option>
	</select>
	<small><?php el3('Select a value or enter the desired value.'); ?></small>
</div>