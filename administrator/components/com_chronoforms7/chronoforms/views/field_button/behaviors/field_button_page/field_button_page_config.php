<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field required">
	<label><?php el3('Submit Page'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][next_page]" class="ui fluid dropdown search" data-list=".pagesList" data-keepnonexistent="1" data-clearable="1">
		<option value=""></option>
	</select>
	<small><?php el3('Select the page to which the button will submit the form, should be in a different page group or your current page group should not be sequential'); ?></small>
</div>