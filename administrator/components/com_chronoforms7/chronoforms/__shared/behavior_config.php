<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$config_path = \G3\Globals::ext_path('chronoforms', 'admin').'behaviors'.DS.$unit['utype'].DS.$behavior['name'].DS.$behavior['name'].'_config.php';
	if(!file_exists($config_path)){
		$config_path = \G3\Globals::ext_path('chronoforms', 'admin').$unit['utype'].DS.$unit['type'].DS.'behaviors'.DS.$behavior['name'].DS.$behavior['name'].'_config.php';
	}
?>
<?php if(file_exists($config_path)): ?>
<div class="ui container segment black secondary attached fluid behavior_config <?php echo $behavior['name']; ?>_config" style="padding-top:3px;">
	<div class="ui label ribbon quti bg-black text-white mb-3">
		<i class="faicon <?php echo $behavior['icon']; ?>"></i>
		<?php echo $behavior['title']; ?>
		<div class="detail"><?php echo $behavior['desc']; ?></div>
	</div>
	<?php $this->view($config_path, ['utype' => $utype, 'n' => $n, 'behavior' => $behavior, 'unit' => $unit]); ?>
</div>
<?php endif; ?>