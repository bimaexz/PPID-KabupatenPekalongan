<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Google reCaptcha site key'); ?></label>
		<input type="text" name="Extension[settings][gcaptcha][sitekey]" value="">
		<small><?php el3('Get this from Google reCaptcha admin area'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Google reCaptcha secret key'); ?></label>
		<input type="text" name="Extension[settings][gcaptcha][secretkey]" value="">
		<small><?php el3('Get this from Google reCaptcha admin area'); ?></small>
	</div>
</div>
<div class="field">
	<label><?php el3('reCaptcha Error message'); ?></label>
	<input type="text" value="You didn't pass the reCaptcha verification." name="Extension[settings][gcaptcha][error]">
	<small><?php el3('Error message to display when the recaptcha check fails'); ?></small>
</div>