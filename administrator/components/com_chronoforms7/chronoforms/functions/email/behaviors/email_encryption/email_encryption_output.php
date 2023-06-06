<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(class_exists('Crypt_GPG')){
		$mySecretKeyId = trim($unit['gpg_sec_key']);
		$gpg = new Crypt_GPG();
		$gpg->addEncryptKey($mySecretKeyId);
		$unit['body'] = $gpg->encrypt($unit['body']);
	}