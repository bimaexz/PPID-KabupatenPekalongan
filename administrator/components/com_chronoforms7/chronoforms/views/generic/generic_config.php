<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui message">
	<?php el3('This is just a paceholder for a non existing form unit'); ?>
</div>

<div class="field">
	<label><?php el3('Unit Settings'); ?></label>
	<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][settings]" rows="20"><?php echo json_encode($unit); ?></textarea>
</div>