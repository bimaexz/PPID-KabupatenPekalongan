<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field required">
	<label><?php el3('URL'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][url]">
	<small><?php el3('Full URL to send the data to'); ?></small>
</div>

<div class="equal width fields">
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][header]" data-ghost="1" value="">
			<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][header]" value="1">
			<label><?php el3('Header in response (CURLOPT_HEADER)'); ?></label>
			<small><?php el3('Include header in the response ?'); ?></small>
		</div>
	</div>
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][post]" data-ghost="1" value="">
			<input type="checkbox" checked="checked" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][post]" value="1">
			<label><?php el3('Post Data'); ?></label>
			<small><?php el3('Use the POST command to send the data to the remote server'); ?></small>
		</div>
	</div>
</div>