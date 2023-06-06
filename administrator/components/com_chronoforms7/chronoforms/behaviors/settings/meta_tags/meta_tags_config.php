<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Page Title'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][meta][title]">
	<small><?php el3('Override the page title'); ?></small>
</div>
<div class="field">
	<label><?php el3('Meta Keywords'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][meta][keywords]">
	<small><?php el3('Override the page meta keywords'); ?></small>
</div>
<div class="field">
	<label><?php el3('Meta Description'); ?></label>
	<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][meta][description]" rows="3"></textarea>
	<small><?php el3('Override the page meta description'); ?></small>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Meta Generator'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][meta][generator]">
		<small><?php el3('Override the page meta generator'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Meta Robots'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][meta][robots]">
		<small><?php el3('Override the page meta robots'); ?></small>
	</div>
</div>