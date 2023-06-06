<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Label'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][label][content]">
	<small><?php el3('Label to be included for this unit'); ?></small>
</div>