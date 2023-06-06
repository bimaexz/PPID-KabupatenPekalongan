<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Options list'); ?></label>
	<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][multiline_options]" rows="7"></textarea>
	<small><?php el3('Multiline list of options'); ?></small>
</div>
<div class="field">
	<label><?php el3('Selected Options list'); ?></label>
	<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][multiline_selected]" rows="3"></textarea>
	<small><?php el3('Multiline list of default selectioned values'); ?></small>
</div>