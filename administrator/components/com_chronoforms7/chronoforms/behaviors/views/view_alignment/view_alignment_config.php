<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Text alignment'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][alignment]" class="ui fluid dropdown" data-clearable="1">
		<option value=""><?php el3('None'); ?></option>
		<option value="right aligned"><?php el3('Right aligned'); ?></option>
		<option value="center aligned"><?php el3('Center aligned'); ?></option>
		<option value="left aligned"><?php el3('Left aligned'); ?></option>
	</select>
	<small><?php el3('Content alignment inside the element'); ?></small>
</div>