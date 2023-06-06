<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Target Unit'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][target]" class="ui fluid dropdown search" data-list=".inputsList,.actionsList" data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('The unit on which the popup will appear'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('On'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-on]" class="ui fluid dropdown" placeholder="">
			<option value="hover"><?php el3('Hover'); ?></option>
			<option value="click"><?php el3('Click'); ?></option>
			<option value="focus"><?php el3('Focus'); ?></option>
			<option value="manual"><?php el3('Manual'); ?></option>
		</select>
		<small><?php el3('The event on which the popup will open automatically'); ?></small>
	</div>
</div>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Hoverable'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-hoverable]" class="ui fluid dropdown" placeholder="">
			<option value="1"><?php el3('Yes'); ?></option>
			<option value=""><?php el3('No'); ?></option>
		</select>
		<small><?php el3('Whether popup should not close on hover'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Position'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-position]" class="ui fluid dropdown" placeholder="">
			<option value="top left"><?php el3('Top Left'); ?></option>
			<option value="top center"><?php el3('Top Center'); ?></option>
			<option value="top right"><?php el3('Top Right'); ?></option>
			<option value="right center"><?php el3('Right Center'); ?></option>
			<option value="left center"><?php el3('Left Center'); ?></option>
			<option value="bottom left"><?php el3('Bottom Left'); ?></option>
			<option value="bottom center"><?php el3('Bottom Center'); ?></option>
			<option value="bottom right"><?php el3('Bottom Right'); ?></option>
		</select>
		<small><?php el3('The position at which the popup will appear relative to the element'); ?></small>
	</div>
</div>
<!-- <div class="equal width fields">
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
<div class="equal width fields">
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