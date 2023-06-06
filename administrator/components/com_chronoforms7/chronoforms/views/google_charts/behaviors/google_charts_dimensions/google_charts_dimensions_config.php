<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Width'); ?></label>
		<input type="text" value="100%" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][chart][options][width]">
		<small><?php el3('Chart width'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Height'); ?></label>
		<input type="text" value="400" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][chart][options][height]">
		<small><?php el3('Chart height'); ?></small>
	</div>
</div>