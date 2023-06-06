<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Toolbar1'); ?></label>
	<input type="text" value="code visualblocks | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-toolbar1]">
	<small><?php el3('Editor toolbar 1 buttons'); ?></small>
	<small><?php el3('Default: %s', ['code visualblocks | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify']); ?></small>
</div>
<div class="field">
	<label><?php el3('Toolbar2'); ?></label>
	<input type="text" value="bullist numlist outdent indent | link image media | forecolor backcolor | hr | removeformat | preview" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-toolbar2]">
	<small><?php el3('Editor toolbar 2 buttons'); ?></small>
	<small><?php el3('Default: %s', ['bullist numlist outdent indent | link image media | forecolor backcolor | hr | removeformat | preview']); ?></small>
</div>
<div class="field">
	<label><?php el3('Toolbar3'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-toolbar3]">
	<small><?php el3('Editor toolbar 3 buttons'); ?></small>
</div>