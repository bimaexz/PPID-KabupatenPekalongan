<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field required">
	<label><?php el3('Code'); ?></label>
	<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][code]" rows="15" data-codeeditor='{"mode":"php"}'></textarea>
	<small><?php el3('PHP code with OUT tags, returned value will be set as var'); ?></small>
</div>