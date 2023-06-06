<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view($this->get('cf.paths.shared').'behavior_config.php', ['utype' => $utype, 'n' => $n, 'behavior' => $behavior, 'unit' => $unit]);
?>