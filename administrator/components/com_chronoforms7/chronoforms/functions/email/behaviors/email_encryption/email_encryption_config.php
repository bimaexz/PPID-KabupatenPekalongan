<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php if(!class_exists('Crypt_GPG')): ?>
	<div class="ui label red"><?php el3('The Crypt_GPG class is NOT loaded'); ?></div>
<?php else: ?>
	<div class="ui label green"><?php el3('The Crypt_GPG class is loaded!'); ?></div>
<?php endif; ?>

<div class="field">
	<label><?php el3('GPG Security key'); ?></label>
	<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][gpg_sec_key]">
</div>