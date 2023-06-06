<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Previewable Extensions'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][download][inline_extensions][]" class="ui fluid dropdown search multiple" multiple="multiple" data-allowadditions="1" data-clearable="1">
			<option value="jpg">jpg</option>
			<option value="png">png</option>
			<option value="gif">gif</option>
		</select>
		<small><?php el3('Select which files extensions will be previewed in the browser directly'); ?></small>
	</div>
</div>