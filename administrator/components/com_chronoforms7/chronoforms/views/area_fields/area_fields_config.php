<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Fields Layout'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][number]" class="ui fluid dropdown" placeholder="">
			<option value="equal width fields"><?php el3('Equal Width'); ?></option>
			<option value="fields"><?php el3('Horizontal'); ?></option>
			<option value="grouped fields"><?php el3('Vertical'); ?></option>
			<!-- <option value="two fields"><?php el3('Two'); ?></option>
			<option value="three fields"><?php el3('Three'); ?></option>
			<option value="four fields"><?php el3('Four'); ?></option>
			<option value="five fields"><?php el3('Five'); ?></option>
			<option value="six fields"><?php el3('Six'); ?></option> -->
		</select>
		<small><?php el3('How the area width will be divided'); ?></small>
	</div>
	
	<!-- <div class="field">
		<label><?php el3('Inline'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][inline]" class="ui fluid dropdown" placeholder="">
			<option value=""><?php el3('No'); ?></option>
			<option value="inline"><?php el3('Yes'); ?></option>
		</select>
		<small><?php el3('If enabled then the labels will be displayed on left side.'); ?></small>
	</div> -->
</div>