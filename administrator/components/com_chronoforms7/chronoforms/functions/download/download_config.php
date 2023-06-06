<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field required">
	<label><?php el3('File or directory path'); ?></label>
	<input type="text" value="{path:root}" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][path]">
</div>

<div class="two fields">
	
	<div class="field">
		<label><?php el3('Direct display extensions'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][inline_extensions][]" multiple="" class="ui fluid dropdown search" data-clearable="1" data-allowadditions="1">
			<option value="png" selected="selected">png</option>
			<option value="jpg" selected="selected">jpg</option>
			<option value="gif" selected="selected">gif</option>
		</select>
		<small><?php el3('Extensions of this list will be directly displayed instead of asking the user to download.'); ?></small>
	</div>
	
	<div class="field">
		<label><?php el3('Auto selection'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][selection]" class="ui fluid dropdown">
			<option value="0"><?php el3('Disabled - use path'); ?></option>
			<option value="last_modified"><?php el3('Last modified'); ?></option>
		</select>
	</div>
</div>