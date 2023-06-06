<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields inline">
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-searchable]" data-ghost="1" value="">
			<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-searchable]" value="1">
			<label><?php el3('Searchable'); ?></label>
			<small><?php el3('The dropdown values can be searched by typing in the field.'); ?></small>
		</div>
	</div>
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-fulltextsearch]" data-ghost="1" value="">
			<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-fulltextsearch]" value="1">
			<label><?php el3('Full text searchable'); ?></label>
			<small><?php el3('Instead of matching the first character only, the whole option label text will be matched.'); ?></small>
		</div>
	</div>
</div>