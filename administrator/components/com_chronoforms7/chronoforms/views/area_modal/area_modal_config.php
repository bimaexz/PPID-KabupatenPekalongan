<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Closable'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-closable]" class="ui fluid dropdown" placeholder="">
			<option value="1"><?php el3('Yes'); ?></option>
			<option value=""><?php el3('No'); ?></option>
		</select>
		<small><?php el3('Will close when the background is clicked.'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Close icon'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][close][active]" class="ui fluid dropdown" placeholder="">
			<option value="1"><?php el3('Yes'); ?></option>
			<option value=""><?php el3('No'); ?></option>
		</select>
		<small><?php el3('Display a close button ?'); ?></small>
	</div>
</div>
<!-- <div class="equal width fields">
	<div class="field">
		<label><?php el3('Detachable'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-detachable]" class="ui fluid dropdown" placeholder="">
			<option value=""><?php el3('No'); ?></option>
			<option value="1"><?php el3('Yes'); ?></option>
		</select>
		<small><?php el3('Code will be moved to the Body node, will affect style and position.'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Full Screen'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][fullscreen]" class="ui fluid dropdown" placeholder="">
			<option value=""><?php el3('No'); ?></option>
			<option value="fullscreen"><?php el3('Screen Wide'); ?></option>
			<option value="fullscreen overlay"><?php el3('Full Screen'); ?></option>
		</select>
		<small><?php el3('Display in Full screen mode'); ?></small>
	</div>
</div>
<div class="field">
	<label><?php el3('Position'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][position]" class="ui fluid dropdown" placeholder="">
		<option value=""><?php el3('Cenetred'); ?></option>
		<option value="top aligned"><?php el3('Top Aligned'); ?></option>
		<option value="bottom aligned"><?php el3('Bottom Aligned'); ?></option>
	</select>
	<small><?php el3('Modal position inside the dimmer'); ?></small>
</div> -->