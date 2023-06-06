<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<!-- <div class="field">
	<div class="ui checkbox toggle">
		<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][altfile][enabled]" data-ghost="1" value="0">
		<input type="checkbox" class="hidden" checked="checked" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][altfile][enabled]" value="1">
		<label><?php el3('Enable the File Placeholder'); ?></label>
		<small><?php el3('Hide the default browser file input and show a placeholder'); ?></small>
	</div>
</div> -->
<div class="field">
	<label><?php el3('No file selected message'); ?></label>
	<input type="text" value="<?php el3('No file(s) selected'); ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][altfile][text]">
</div>