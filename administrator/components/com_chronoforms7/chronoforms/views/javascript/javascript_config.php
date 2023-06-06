<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<div class="ui checkbox toggle">
		<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][domready]" data-ghost="1" value="0">
		<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][domready]" value="1">
		<label><?php el3('Add inside domready event'); ?></label>
		<small><?php el3('If enabled then the code will be placed inside a JQuery domready event and will run after the page is loaded.'); ?></small>
	</div>
</div>

<div class="field">
	<label><?php el3('Content'); ?></label>
	<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][content]" rows="20" data-codeeditor='{"mode":"javascript"}'></textarea>
	<small><?php el3('JavaScript code WITHOUT script tags'); ?></small>
</div>