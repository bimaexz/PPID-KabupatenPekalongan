<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field required">
	<label><?php el3('SQL Code'); ?></label>
	<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][code]" rows="15" data-codeeditor='{"mode":"sql"}'></textarea>
	<small><?php el3('The SQL code to be processed, you can use PHP code, you can quote request values with $dbo->quote($value)'); ?></small>
</div>