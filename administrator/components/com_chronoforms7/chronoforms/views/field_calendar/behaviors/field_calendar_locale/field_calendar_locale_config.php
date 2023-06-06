<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Calendar Language'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][calendar][locale]" class="ui fluid dropdown" data-clearable="1">
			<option value=""><?php el3('Auto'); ?></option>
			<option value="en"><?php el3('English'); ?></option>
			<option value="de"><?php el3('German'); ?></option>
			<option value="it"><?php el3('Italian'); ?></option>
			<option value="ru"><?php el3('Russian'); ?></option>
			<option value="nl"><?php el3('Dutch'); ?></option>
			<option value="fr"><?php el3('French'); ?></option>
			<option value="sp"><?php el3('Spanish'); ?></option>
		</select>
		<small><?php el3('Which language should be used for displaying the date months and days'); ?></small>
	</div>
</div>