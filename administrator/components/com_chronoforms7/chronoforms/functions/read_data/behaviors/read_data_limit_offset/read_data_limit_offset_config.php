<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Limit'); ?></label>
		<input type="text" value="30" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][models][data][limit]" />
		<small><?php el3('The limit of the returned list of records, will be used as page liit when paging is enabled'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Offset'); ?></label>
		<input type="text" value="0" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][models][data][offset]" />
		<small><?php el3('The offset of the returned list of records'); ?></small>
	</div>
</div>