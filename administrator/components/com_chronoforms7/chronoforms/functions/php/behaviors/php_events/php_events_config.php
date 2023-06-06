<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view($this->get('cf.paths.shared').'parameters_config.php', [
		'unit' => $unit, 
		'utype' => $utype, 
		'n' => $n,
		'name' => 'areas',
		'text' => rl3('Add Return Event'),
		'name_label' => rl3('Event Name'),
		'value_label' => rl3('Return Value'),
	]);
?>

<?php $this->view($this->get('cf.paths.shared').'refresh_button.php'); ?>