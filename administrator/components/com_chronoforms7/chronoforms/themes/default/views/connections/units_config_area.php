<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$unit_path = \G3\Globals::ext_path('chronoforms', 'admin').$utype.DS.$type.DS.$type.'_config.php';
	$ini_path = \G3\Globals::ext_path('chronoforms', 'admin').$utype.DS.$type.DS.$type.'.php';

	if(!file_exists($unit_path)){
		$this->data['Connection'][$utype][$count]['type'] = $type = 'generic';
		$unit_path = \G3\Globals::ext_path('chronoforms', 'admin').$utype.DS.$type.DS.$type.'_config.php';
		$ini_path = \G3\Globals::ext_path('chronoforms', 'admin').$utype.DS.$type.DS.$type.'.php';
	}
	
	$info = require($ini_path);
	
	$unit['info'] = $info;
?>
<div class="config_area transition hidden" style="padding-top:5px;">
	<div class="ui message top attached">
		<input type="hidden" value="<?php echo $count; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $count; ?>][uid]">
		<input type="hidden" value="" name="Connection[<?php echo $utype; ?>][<?php echo $count; ?>][_parent]" class="parent_id">
		<input type="hidden" value="" name="Connection[<?php echo $utype; ?>][<?php echo $count; ?>][_area]" class="parent_area">
		<input type="hidden" value="<?php echo $unit['name']; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $count; ?>][name]" class="unit-name">
		<input type="hidden" value="" name="Connection[<?php echo $utype; ?>][<?php echo $count; ?>][wtitle]" class="unit-wtitle">

		<?php if(empty($safe_mode)): ?>
		<input type="hidden" value="<?php echo $utype; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $count; ?>][utype]">
		<input type="hidden" value="<?php echo $type; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $count; ?>][type]">
		
		<?php
			if(!empty($info['config']['basics'])){
				$this->view($this->get('cf.paths.shared').'field_basics.php', ['unit' => $unit, 'n' => $count, 'type' => $info['name']]);
			}
		?>
		<?php
			if(!empty($info['config']['options'])){
				$this->view($this->get('cf.paths.shared').'options_config.php', ['unit' => $unit, 'utype' => $utype, 'n' => $count]);
			}
		?>
		<?php
			$this->view($unit_path, ['utype' => $utype, 'n' => $count, 'unit' => $unit]);
		?>
		<?php endif; ?>

	</div>
	<?php if(empty($safe_mode)): ?>
		<?php $this->view($this->get('cf.paths.shared').'behaviors_list.php', ['unit' => $unit]); ?>
	<?php endif; ?>

</div>