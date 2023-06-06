<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Validation messages'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-vmsgs]" class="ui fluid dropdown">
		<option value="inlinetext"><?php el3('Inline error messages'); ?></option>
		<option value="inline"><?php el3('Inline tooltips'); ?></option>
		<option value="message"><?php el3('Errors list below form'); ?></option>
	</select>
</div>