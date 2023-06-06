<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field required">
		<label><?php el3('Page'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][form_page]" class="ui fluid dropdown search" data-list=".pagesList" data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Which page should be loaded ? This page should be StandAlone OR a start page in a Sequential PageGroup'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Stop processing'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][stop]" class="ui fluid dropdown" placeholder="">
			<option value="1"><?php el3('Yes'); ?></option>
			<option value=""><?php el3('No'); ?></option>
		</select>
		<small><?php el3('Abort processing and don not display the current page output'); ?></small>
	</div>
</div>