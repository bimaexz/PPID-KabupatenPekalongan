<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Size'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][<?php echo $node ?? 'main'; ?>][attrs][class][size]" class="ui fluid dropdown" data-clearable="1">
		<option value=""><?php el3('Default'); ?></option>
		<option value="mini"><?php el3('Mini'); ?></option>
		<option value="tiny"><?php el3('Tiny'); ?></option>
		<option value="small"><?php el3('Small'); ?></option>
		<option value="large"><?php el3('Large'); ?></option>
		<option value="big"><?php el3('Big'); ?></option>
		<option value="huge"><?php el3('Huge'); ?></option>
		<option value="massive"><?php el3('Massive'); ?></option>
	</select>
</div>