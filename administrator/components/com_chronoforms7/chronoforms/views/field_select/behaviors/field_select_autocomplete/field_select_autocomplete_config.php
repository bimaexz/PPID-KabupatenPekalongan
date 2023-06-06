<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="fields">
	<div class="ten wide field">
		<label><?php el3('Autocomplete page'); ?></label>
		<select name="Connection[views][<?php echo $n; ?>][complete][page]" class="ui fluid dropdown search" data-list=".pagesList" data-allowadditions="1" data-clearable="1">
			<option value=""></option>
			<option value="load">load</option><?php //needed to allow the dropdown to open and use the onShow event ?>
		</select>
		<small><?php el3('The form page to be accessed for getting the auto complete results, the results must be a json encoded array'); ?></small>
	</div>
	<div class="six wide field">
		<label><?php el3('Minimum Characters to autocomplete'); ?></label>
		<input type="text" value="2" name="Connection[views][<?php echo $n; ?>][nodes][main][attrs][data-completemin]">
		<small><?php el3('Minimum number of characters to be typed for the auto complete to fetch results.'); ?></small>
	</div>
</div>