<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Minimum length'); ?></label>
		<input type="text" value="" name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][minLength]">
		<small><?php el3('The minimum number of characters in the field value'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Maximum length'); ?></label>
		<input type="text" value="" name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][rules][maxLength]">
		<small><?php el3('The maximum number of characters in the field value'); ?></small>
	</div>
</div>