<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Mask'); ?></label>
		<select name="Connection[views][<?php echo $n; ?>][nodes][main][attrs][data-inputmask]" class="ui fluid dropdown search" data-clearable="1" data-allowadditions="1">
			<option value=""><?php el3('None'); ?></option>
			<option value="'alias': 'dd/mm/yyyy'">dd/mm/yyyy</option>
			<option value="'alias': 'dd.mm.yyyy'">dd.mm.yyyy</option>
			<option value="'alias': 'dd-mm-yyyy'">dd-mm-yyyy</option>
			<option value="'alias': 'mm/dd/yyyy'">mm/dd/yyyy</option>
			<option value="'alias': 'mm.dd.yyyy'">mm.dd.yyyy</option>
			<option value="'alias': 'mm-dd-yyyy'">mm-dd-yyyy</option>
			<option value="'alias': 'yyyy/mm/dd'">yyyy/mm/dd</option>
			<option value="'alias': 'yyyy.mm.dd'">yyyy.mm.dd</option>
			<option value="'alias': 'yyyy-mm-dd'">yyyy-mm-dd</option>
			
			<option value="'alias': 'mm/yyyy'">mm/yyyy</option>
			
			<option value="'alias': 'datetime'">datetime : dd/mm/yyyy hh:mm</option>
			<option value="'alias': 'datetime12'">datetime12 : dd/mm/yyyy hh:mm xm</option>
			
			<option value="'alias': 'hh:mm t'">hh:mm t</option>
			<option value="'alias': 'h:s t'">h:s t</option>
			<option value="'alias': 'hh:mm:ss'">hh:mm:ss</option>
			<option value="'alias': 'hh:mm'">hh:mm</option>
			
			<option value="'alias': 'decimal'">Decimal</option>
			<option value="'alias': 'integer'">Integer</option>
			<option value="'alias': 'url'">URL</option>
			<option value="'alias': 'ip'">IP Address</option>
			<option value="'mask': '+9(999)999-9999'">Phone: +9(999)999-9999</option>
		</select>
		<small><?php el3('Choose a mask format or enter a new one!'); ?></small>
	</div>
</div>