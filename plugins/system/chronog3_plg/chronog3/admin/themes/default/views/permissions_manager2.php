<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	ob_start();
?>
<?php
	$jscode = ob_get_clean();
	\GApp3::document()->addJsCode($jscode);
?>
<?php $perm_selections = array(0 => rl3('Inherited/Neutral'), 1 => rl3('Allowed'), -1 => rl3('Denied')); ?>
<?php
	if(\G3\Globals::get('app') == 'wordpress'){
		$groups = array_merge($groups, \GApp3::get_gcore_wp_usergroups());
	}
?>
<?php foreach($groups as $k => $group): ?>
	<div class="field" style="margin-left:<?php echo 25 * count($group['Group']['_parents']); ?>px;">
		<label>
			<?php echo str_repeat('<i class="faicon angle-right depth"></i>', count($group['Group']['_parents'])); ?>
			<?php echo $group['Group']['title']; ?>
		</label>
		<select name="AclProfile[rules][<?php echo $group['Group']['id']; ?>]" data-rich="1" >
			<?php foreach($perm_selections as $id => $title): ?>
			<?php
				$icon = '';
				// if(!empty($behavior['icon'])){
				// 	$icon = 'data-iconsvg=\'<i class="faicon '.$behavior['icon'].'"></i>\'';
				// }
			?>
			<option value="<?php echo $id; ?>" <?php echo $icon; ?>><?php echo $title; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
<?php endforeach; ?>