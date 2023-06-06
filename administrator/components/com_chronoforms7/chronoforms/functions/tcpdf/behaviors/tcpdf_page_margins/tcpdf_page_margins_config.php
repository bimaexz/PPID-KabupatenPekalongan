<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Top margin'); ?></label>
		<input type="text" value="27" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_margin_top]">
	</div>
	<div class="field">
		<label><?php el3('Bottom margin'); ?></label>
		<input type="text" value="25" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_margin_bottom]">
	</div>
	<div class="field">
		<label><?php el3('Right margin'); ?></label>
		<input type="text" value="15" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_margin_right]">
	</div>
	<div class="field">
		<label><?php el3('Left margin'); ?></label>
		<input type="text" value="15" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_margin_left]">
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Header margin'); ?></label>
		<input type="text" value="5" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_margin_header]">
	</div>
	<div class="field">
		<label><?php el3('Footer margin'); ?></label>
		<input type="text" value="10" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_margin_footer]">
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][disable_pdf_header]" data-ghost="1" value="">
			<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][disable_pdf_header]" value="1">
			<label><?php el3('Disable Header'); ?></label>
			<small><?php el3('Disable PDF pages headers'); ?></small>
		</div>
	</div>
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][disable_pdf_footer]" data-ghost="1" value="">
			<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][disable_pdf_footer]" value="1">
			<label><?php el3('Disable Footer'); ?></label>
			<small><?php el3('Disable PDF pages footers'); ?></small>
		</div>
	</div>
</div>