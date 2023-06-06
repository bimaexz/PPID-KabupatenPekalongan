<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Image Path'); ?></label>
		<input type="text" value="{path:front}<?php echo DS.'files'.DS.'signature-{date:U}.png'; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][image][path]">
		<small><?php el3('The absolute path to the image file including te file name'); ?></small>
	</div>
</div>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Image Path Data Postfix'); ?></label>
		<input type="text" value="_image_path" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][image][path_postfix]">
		<small><?php el3('The field name postfix under which the image path is set in the data array'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Image name Data Postfix'); ?></label>
		<input type="text" value="_image_name" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][image][name_postfix]">
		<small><?php el3('The field name postfix under which the image name is set in the data array'); ?></small>
	</div>
</div>