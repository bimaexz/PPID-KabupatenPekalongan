<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<h2 class="ui header"><?php el3('Restore a Chronoforms7 Locales backup file'); ?></h2>

<div class="ui clearing divider"></div>

<div class="ui bottom attached tab segment active" data-tab="general">
	
	<div class="grouped two fields">
		<div class="field">
			<label><?php el3('File'); ?></label>
			<input type="file" name="backup">
		</div>
		<div class="field">
			<button class="compact ui button green icon labeled" name="restore"><i class="faicon check"></i><?php el3('Upload & Restore'); ?></button>
		</div>
	</div>
	
</div>
