<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Values'); ?></label>
	<?php $this->view(dirname(__FILE__).DS.'values_config.php', ['unit' => $unit, 'utype' => $utype, 'n' => $n]); ?>
</div>