<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Task'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][checkbox][attrs][class][selector]" class="ui fluid dropdown">
			<option value="selector"><?php el3('Single Entry Selector'); ?></option>
			<option value="select_all"><?php el3('Toggle Selectors (Select All)'); ?></option>
		</select>
		<small><?php el3('Should the checkbox select table entries or toggle other selectors ?'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Selection Color'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-selectionclass]" class="ui fluid dropdown search" data-allowadditions="1">
			<option value="warning"><?php echo 'warning'; ?></option>
			<option value="error"><?php echo 'error'; ?></option>
			<option value="info"><?php echo 'info'; ?></option>
			<option value="success"><?php echo 'success'; ?></option>
		</select>
		<small><?php el3('The class added to the table row on selection'); ?></small>
	</div>
</div>