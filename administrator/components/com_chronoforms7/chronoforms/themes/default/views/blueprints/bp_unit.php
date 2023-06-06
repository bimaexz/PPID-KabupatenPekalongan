<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$unit_info_file = $bp_path.$flownode['list'].DS.$flownode['group'].DS.$flownode['name'].DS.$flownode['name'].'.php';
	$unit_info = require($unit_info_file);

	$group_info_file = $bp_path.$flownode['list'].DS.$flownode['group'].DS.$flownode['group'].'.php';
	$group_info = require($group_info_file);

	$info = array_replace_recursive($group_info, $unit_info);

	$nid = $info['name'].$uid;

	$rows = (count($info['inputs']) > count($info['outputs'])) ? $info['inputs'] : $info['outputs'];
	
	$multi = [];
	foreach(array_values($rows) as $rk => $rv){
		$multi['in'][$rk]['key'] = array_keys($info['inputs'])[$rk] ?? '';
		$multi['in'][$rk]['value'] = array_values($info['inputs'])[$rk] ?? '';

		$multi['out'][$rk]['key'] = array_keys($info['outputs'])[$rk] ?? '';
		$multi['out'][$rk]['value'] = array_values($info['outputs'])[$rk] ?? '';
	}

	$multi['in'] = $multi['in'] ?? [];
	$multi['out'] = $multi['out'] ?? [];
?>
<div class="flownode" data-uid="<?php echo $uid; ?>" data-name="<?php echo $info['name']; ?>" data-group="<?php echo $info['group']; ?>" data-list="<?php echo $info['list']; ?>" style="display:table;min-width:100px;">
	<input type="hidden" value="<?php echo $uid; ?>" name="flownodes[<?php echo $uid; ?>][uid]">
	<input type="hidden" value="<?php echo $info['name']; ?>" name="flownodes[<?php echo $uid; ?>][name]">
	<input type="hidden" value="<?php echo $info['group']; ?>" name="flownodes[<?php echo $uid; ?>][group]">
	<input type="hidden" value="<?php echo $info['list']; ?>" name="flownodes[<?php echo $uid; ?>][list]">
	<input type="hidden" value="" name="flownodes[<?php echo $uid; ?>][offset]" class="flownode-offset-value">

	<div class="ui menu flownode-header top attached borderless inverted quti bg-<?php echo $info['color']; ?>700  cursor-move" style="padding:5px;">
		<div class="item quti p-1">
			<i class="faicon <?php echo $info['icon']; ?> link flownode-handle"></i>&nbsp;
		</div>
		<div class="item quti p-1">
			<?php echo $info['title']; ?>
		</div>
		<!-- <div class="item quti p-1">
			<i class="faicon info link flownode-info" data-hint="<?php echo $info['info']; ?>"></i>&nbsp;
		</div> -->
		<div class="item quti p-1">
			&nbsp;&nbsp;&nbsp;
		</div>
		<div class="item right quti p-1">
			<div class="dragged_actions">
				<i class="faicon times link flownode-delete dragged_action quti text-red cursor-pointer" data-hint="<?php el3('Delete'); ?>"></i>
				
				<!-- <i class="faicon sort link flownode-sort dragged_action quti text-orange cursor-pointer" data-hint="<?php el3('Sort'); ?>"></i> -->
				
				<i class="faicon cog link flownode-edit dragged_action quti text-white cursor-pointer" data-hint="<?php el3('Edit'); ?>"></i>
			</div>
		</div>
	</div>
	<div class="ui segment bottom attached" style="padding:3px;">
		<table class="ui single line compact very basic table">
			<tbody>
				<?php foreach($multi['in'] as $mk => $mv): ?>
					<?php if(!empty($multi['in'][$mk]['value']) OR !empty($multi['out'][$mk]['value'])): ?>
						<tr>
							<td>
								<?php if(!empty($multi['in'][$mk]['value'])): ?>
									<?php if($multi['in'][$mk]['key'] == 'exec'): ?>
										<i class="faicon solid:caret-square-right link flownode-input quti text-ml" data-uid="<?php echo $uid; ?>/in/<?php echo $multi['in'][$mk]['key']; ?>" data-info='<?php echo json_encode($multi['in'][$mk]['value']); ?>' data-type="<?php echo $multi['in'][$mk]['value']['type']; ?>"></i>
									<?php else: ?>
										<i class="faicon solid:arrow-alt-circle-right link flownode-input quti text-ml" data-uid="<?php echo $uid; ?>/in/<?php echo $multi['in'][$mk]['key']; ?>" data-info='<?php echo json_encode($multi['in'][$mk]['value']); ?>' data-type="<?php echo $multi['in'][$mk]['value']['type']; ?>"></i>
										<?php echo $multi['in'][$mk]['value']['title']; ?>
									<?php endif; ?>
								<?php endif; ?>
							</td>
							<td style="text-align:right">
								<?php if(!empty($multi['out'][$mk]['value'])): ?>
									<?php if($multi['out'][$mk]['key'] == 'exec'): ?>
										<i class="faicon solid:caret-square-right link flownode-output quti text-ml" data-uid="<?php echo $uid; ?>/out/<?php echo $multi['out'][$mk]['key']; ?>" data-info='<?php echo json_encode($multi['out'][$mk]['value']); ?>' data-type="<?php echo $multi['out'][$mk]['value']['type']; ?>"></i>
									<?php else: ?>
										<?php echo $multi['out'][$mk]['value']['title']; ?>
										<i class="faicon solid:arrow-alt-circle-right link flownode-output quti text-ml" data-uid="<?php echo $uid; ?>/out/<?php echo $multi['out'][$mk]['key']; ?>" data-info='<?php echo json_encode($multi['out'][$mk]['value']); ?>' data-type="<?php echo $multi['out'][$mk]['value']['type']; ?>"></i>
									<?php endif; ?>
								<?php endif; ?>
							</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>