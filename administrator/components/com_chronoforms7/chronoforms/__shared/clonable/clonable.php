<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$group0 = $groups[0];
	// $group1 = false;
	// if(!empty($groups)){
	// 	$group1 = array_shift($groups);
	// }

	if(empty($visible)){
		$visible = [$group0 => 0];
	}

	$source = [1];
	// if(!empty($group1)){
	// 	$source = [[$group1 => [1]]];
	// }
	$start = $source;

	if(!empty($visible[$group0])){
		$start = array_merge(range(1, $visible[$group0]), $source);
	}

	if(empty($items)){
		$items = $start;
	}else{
		if(!isset($items[0])){
			$items = (array)$source + (array)$items;
		}else{
			$items = array_merge((array)$source, (array)$items);
		}
	}

	$counter = !empty($items) ? max(array_keys($items)) : 0;

	$grouptypes = array_keys($inputs[$group0]);
?>
<div class="ui container fluid form tiny clonable_container" data-group="<?php echo $group0; ?>" data-lastindex="<?php echo $counter; ?>">
	<?php if(!empty($btns[$group0])): ?>
		<?php foreach($btns[$group0] as $grouptype => $btn): ?>
			<?php
				$btn = array_merge(['color' => 'blue', 'icon' => 'plus'], $btn);
			?>
			<div class="field">
				<button type="button" data-group="<?php echo $group0; ?>" data-cloning="source" class="ui button icon compact labeled <?php echo $btn['color']; ?> tiny add_clone"><i class="faicon <?php echo $btn['icon']; ?>"></i><?php echo $btn['text']; ?></button>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php if(!empty($headers[$group0])): ?>
		<div class="equal width fields" style="margin-bottom:0;">
		<?php foreach($headers[$group0] as $header): ?>
			<?php
				if(!empty($header['ignore'])){
					continue;
				}
			?>
			<div class="<?php echo $header['width']; ?> field">
				<?php if(!empty($header['label'])): ?><label class="ui label"><?php echo $header['label']; ?></label><?php endif; ?>
			</div>
		<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php foreach($items as $kg0 => $item0): ?>
		<?php foreach($grouptypes as $grouptype): ?>
			<?php if($grouptype == 'main' OR ($grouptype != 'main' AND ($kg0 == 0 OR $item0['_type'] == $grouptype))): ?>
				<div class="field clonable <?php echo $class ?? ''; ?>" data-group="<?php echo $group0; ?>" data-grouptype="<?php echo $grouptype; ?>" <?php if($kg0 === 0): ?>data-source="1"<?php endif; ?> data-cloneindex="<?php echo $kg0; ?>">
					<?php
						if(!empty($parents)){
							$keys = array_merge($parents, ['#'.$group0.'#' => $kg0]);
						}else{
							$keys = ['#'.$group0.'#' => $kg0];
						}
					?>
					<?php $this->view(dirname(__FILE__).DS.'inputs.php', ['item' => $item0, 'inputs' => $inputs, 'group' => $group0, 'grouptype' => $grouptype, 'key' => $kg0, 'keys' => $keys]); ?>
					
					<?php if(!empty($divider)): ?>
						<div class="ui divider"></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endforeach; ?>

</div>