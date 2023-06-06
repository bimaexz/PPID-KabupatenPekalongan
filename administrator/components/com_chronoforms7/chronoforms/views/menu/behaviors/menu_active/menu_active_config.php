<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Active Item'); ?></label>
	<input type="text" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][active]" />
	<small><?php el3('Enter the id of the item to be active'); ?></small>
</div>