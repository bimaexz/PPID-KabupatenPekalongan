<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Error message'); ?></label>
	<input type="text" value="" name="Connection[views][<?php echo $n; ?>][fns][validation][fields][<?php echo $n; ?>][error]">
	<small><?php el3('The error message to be displayed when the field fails the validation test.'); ?></small>
</div>