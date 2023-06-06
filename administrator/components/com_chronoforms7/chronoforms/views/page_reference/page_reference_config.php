<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Page'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][page_uid]" class="ui fluid dropdown search" data-list=".pagesList" data-keepnonexistent="1" data-clearable="1">
		<option value=""></option>
	</select>
	<small><?php el3('Form page to display'); ?></small>
</div>