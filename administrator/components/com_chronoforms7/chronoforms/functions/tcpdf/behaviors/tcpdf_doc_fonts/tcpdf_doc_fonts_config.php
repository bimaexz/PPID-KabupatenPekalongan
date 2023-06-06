<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="two fields">
	<div class="field">
		<label><?php el3('Body font'); ?></label>
		<input type="text" value="courier" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_body_font]">
	</div>
	<div class="field">
		<label><?php el3('Body font size'); ?></label>
		<input type="text" value="14" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_body_font_size]">
	</div>
</div>

<div class="two fields">
	<div class="field">
		<label><?php el3('Header font'); ?></label>
		<input type="text" value="helvetica" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_header_font]">
	</div>
	<div class="field">
		<label><?php el3('Header font size'); ?></label>
		<input type="text" value="10" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_header_font_size]">
	</div>
</div>

<div class="two fields">
	<div class="field">
		<label><?php el3('Footer font'); ?></label>
		<input type="text" value="helvetica" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_footer_font]">
	</div>
	<div class="field">
		<label><?php el3('Footer font size'); ?></label>
		<input type="text" value="8" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_footer_font_size]">
	</div>
</div>