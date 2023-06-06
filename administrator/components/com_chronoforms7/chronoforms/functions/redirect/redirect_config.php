<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="ten wide field">
		<label><?php el3('Page/URL'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pageurl]" class="ui fluid dropdown search" data-list=".pagesList" data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Full URL or form page to redirect the user to'); ?></small>
	</div>
	
	<div class="six wide field">
		<label><?php el3('Time delay'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][time]">
		<small><?php el3('Enter a number of seconds to wait before redirecting'); ?></small>
	</div>
</div>