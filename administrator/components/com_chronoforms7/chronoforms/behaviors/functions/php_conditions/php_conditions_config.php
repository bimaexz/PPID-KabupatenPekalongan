<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field required">
	<label><?php el3('PHP Conditions'); ?></label>
	<textarea rows="10" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][php_where]"></textarea>
	<small><?php el3('PHP code without tags to return an array of conditions'); ?>, e.g: return [
	["field_1", 1, "="],
	["field_2", 2, "!="]
];</small>
</div>