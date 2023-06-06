<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$type = $unit['type'];
	$utype = $unit['utype'];
	$n = $unit['uid'];

	$unit_types = [
		'settings' => rl3('Form'),
		'pages' => rl3('Page'),
		'views' => rl3('View'),
		'functions' => rl3('Action'),
	];

	$colors = [
		'html' => 'teal',
		'data' => 'violet',
		'validation' => 'red',
		'tasks' => 'orange',
		'admin' => 'blue',
	];

	$titles = [
		'html' => rl3('Interface'),
		'data' => rl3('Data'),
		'validation' => rl3('Validation'),
		'tasks' => rl3('Tasks'),
		'admin' => rl3('Admin'),
	];

	$texts = [
		'html' => rl3('Behaviors here will affect the appearance and HTML of this unit'),
		'data' => rl3('Behaviors here will change the data and processing features of this unit'),
		'validation' => rl3('Behaviors here will update the validation settings of this unit'),
		'tasks' => rl3('Behaviors here will add extra functionality to the form'),
		'admin' => rl3('Behaviors here will add control some admin features of the form'),
	];

	if(is_null($this->get('behaviors.'.$utype.'.'.$type))){
		$groups = [];
		$behaviors = $this->controller->Behaviors->list('config_order')[$utype];
		// foreach($cats as $category => $behaviors){
			foreach($behaviors as $k => $behavior){
				$utype_ok = (!empty($behavior['accept'][$utype]) AND $behavior['accept'][$utype] === true);
				$included = (!empty($behavior['accept'][$utype]) AND is_array($behavior['accept'][$utype]) AND in_array($type, $behavior['accept'][$utype]));
				$ugroup_ok = (!empty($unit['info']['ugroups']) AND isset($behavior['accept']['ugroups']) AND !empty(array_intersect($unit['info']['ugroups'], $behavior['accept']['ugroups'])));
				$ugroup_denied = (!empty($unit['info']['ugroups']) AND isset($behavior['not_accept']['ugroups']) AND !empty(array_intersect($unit['info']['ugroups'], $behavior['not_accept']['ugroups'])));
				$type_denied = (isset($behavior['not_accept'][$utype]) AND in_array($type, $behavior['not_accept'][$utype]));

				if(!$type_denied AND !$ugroup_denied AND ($utype_ok OR $included OR $ugroup_ok)){
					if(empty($behavior['hidden'])){
						$groups[$behavior['group']][] = $behavior;
					}
				}
			}
		// }
		$this->set('behaviors.'.$utype.'.'.$type, $groups);
	}

	$groups = $this->get('behaviors.'.$utype.'.'.$type);

	if(empty($glist)){
		$glist = array_keys($titles);
	}
	if(!empty($groups[$type])){
		// $glist = array_merge([$type], $glist);
		$glist[] = $type;
	}
	$glist = array_unique($glist);

	$_counter = 0;
	$attached = 'attached';
	if(in_array($unit['utype'], ['views', 'functions'])){
		$attached = 'attached';
	}

	$bconfigs = $this->controller->Behaviors->bconfigs($unit);
	if(!empty($groups['configs'])){
		$bconfigs = array_merge($bconfigs, $groups['configs']);
	}

	if(!empty($bconfigs)){
		echo '<div class="ui '.$attached.' inverted menu small G3-tabs quti bg-grey600">';
		echo '<div class="ui header item small" style="color:#fff;"><i class="faicon cog"></i>'.rl3('Advanced Settings').'</div>';
		
		echo '</div>';
		$selected_behaviors = [];
		?>
		<div class="ui container attached segment small fluid behaviors_settings" data-tab="<?php echo $utype; ?>-behavior-configs-<?php echo $unit['uid']; ?>" style="">
			<div class="field">
				<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][behaviors][<?php echo $unit['type']; ?>][]" class="ui fluid multiple search selection dropdown" multiple="multiple" data-cfwizardjob="behavior-selection" data-rich="1" data-fulltextsearch="1" data-url="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=behavior_config&bgroup=configs&tvout=view&Connection[id]='.$this->data('Connection.id')); ?>" data-utype="<?php echo $utype; ?>" data-count="<?php echo $n; ?>" data-type="<?php echo $unit['type']; ?>">
					<?php foreach($bconfigs as $behavior): ?>
						<?php
							if(!empty($behavior['hidden'])){
								continue;
							}
							$accepted[] = $behavior;
							$selected = '';
							if(false AND !is_null($this->get('cf_settings.behaviors.defaults.'.$behavior['name']))){
								if(!empty($this->get('cf_settings.behaviors.defaults.'.$behavior['name']))){
									$selected = 'selected="selected"';
									$selected_behaviors[] = $behavior['name'];
								}
							}else{
								if(!empty($behavior['default'])){
									$selected = 'selected="selected"';
									$selected_behaviors[] = $behavior['name'];
								}
							}

							$icon = '';
							if(!empty($behavior['icon'])){
								$icon = 'data-iconsvg=\'<i class="faicon '.$behavior['icon'].' '.((!$this->get('__valid') AND !empty($behavior['paid'])) ? 'red' : '').'"></i>\'';
							}
						?>
						<option value="<?php echo $behavior['name']; ?>" <?php echo $icon; ?> data-text="<?php echo $behavior['title']; ?>" data-label="<?php echo $behavior['title']; ?>" data-labelcolor="black" <?php echo $selected; ?> data-tooltip="<?php echo $behavior['desc']; ?>" data-config="<?php echo (int)$behavior['has_config']; ?>"><?php echo $behavior['desc']; ?></option>
					<?php endforeach; ?>
				</select>
				<small><?php el3('Enable Unit Specific Settings'); ?></small>
			</div>
			<div class="ui container fluid behaviors_config_area">
			<?php
				if(count($this->data('Connection.'.$utype.'.'.$n.'.behaviors.'.$unit['type'], []))){
					$selected_behaviors = $this->data('Connection.'.$utype.'.'.$n.'.behaviors.'.$unit['type'], []);
				}
				
				if(count($selected_behaviors)){
					foreach($accepted as $behavior){
						if(in_array($behavior['name'], $selected_behaviors)){
							$this->view(dirname(__FILE__).DS.'behavior_config.php', ['utype' => $utype, 'n' => $n, 'behavior' => $behavior, 'unit' => $unit, 'config' => true]);
						}
					}
				}
			?>
			</div>
		</div>
		<?php
	}

	echo '<div class="ui '.$attached.' inverted menu small G3-tabs quti bg-grey700">';
	echo '<div class="ui header item small" style="color:#fff;"><i class="faicon clipboard list"></i>'.rl3('Behaviors').'</div>';
	foreach($glist as $k => $group){
		if(empty($groups[$group])){
			continue;
		}
		$cats = $groups[$group];
		$color = !empty($colors[$group]) ? $colors[$group] : 'blue';
		$desc = !empty($texts[$group]) ? $texts[$group] : '';
		$title = !empty($titles[$group]) ? $titles[$group] : rl3('Special');
		$active = '';
		if($_counter == 0){
			$active = 'active';
			$_counter++;
		}
		$label = !empty($this->data('Connection.'.$utype.'.'.$n.'.behaviors.'.$group)) ? '<label class="ui label black basic">'.count($this->data('Connection.'.$utype.'.'.$n.'.behaviors.'.$group)).'</label>' : '';
		echo '<a class="item '.$active.' '.$color.'" data-tab="'.$utype.'-behavior-'.$group.'-'.$unit['uid'].'">'.$title.$label.'</a>';
	}
	echo '</div>';

	$_counter = 0;
	foreach($glist as $k => $group){
		if(empty($groups[$group])){
			continue;
		}
		$cats = $groups[$group];
		$color = !empty($colors[$group]) ? $colors[$group] : 'blue';
		$desc = !empty($texts[$group]) ? $texts[$group] : rl3('Unit Specific Behaviors');
		$title = !empty($titles[$group]) ? $titles[$group] : $group;
		$active = '';
		if($_counter == 0){
			$active = 'active';
			$_counter++;
		}

		$accepted = [];
		$selected_behaviors = [];
		
	?>
	<div class="ui container bottom attached borderless segment message small tab <?php echo $active; ?> <?php echo $color; ?> fluid behaviors_settings" data-tab="<?php echo $utype; ?>-behavior-<?php echo $group; ?>-<?php echo $unit['uid']; ?>" style="">
		<div class="field">
			<!-- <input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][behaviors][<?php echo $group; ?>]" data-ghost="1" value=""> -->
			<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][behaviors][<?php echo $group; ?>][]" class="ui fluid multiple search selection dropdown" multiple="multiple" data-cfwizardjob="behavior-selection" data-rich="1" data-fulltextsearch="1" data-url="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=behavior_config&tvout=view&Connection[id]='.$this->data('Connection.id')); ?>" data-utype="<?php echo $utype; ?>" data-count="<?php echo $n; ?>" data-type="<?php echo $unit['type']; ?>">
				<?php //foreach($groups[$group] as $behaviors): ?>
					<?php foreach($groups[$group] as $behavior): ?>
						<?php
							if(!empty($behavior['hidden'])){
								continue;
							}
							$accepted[] = $behavior;
							$selected = '';
							if(false AND !is_null($this->get('cf_settings.behaviors.defaults.'.$behavior['name']))){
								if(!empty($this->get('cf_settings.behaviors.defaults.'.$behavior['name']))){
									$selected = 'selected="selected"';
									$selected_behaviors[] = $behavior['name'];
								}
							}else{
								if(!empty($behavior['default'])){
									$selected = 'selected="selected"';
									$selected_behaviors[] = $behavior['name'];
								}
							}

							$icon = '';
							if(!empty($behavior['icon'])){
								$icon = 'data-iconsvg=\'<i class="faicon '.$behavior['icon'].' '.((!$this->get('__valid') AND !empty($behavior['paid'])) ? 'red' : '').'"></i>\'';
							}
						?>
						<option value="<?php echo $behavior['name']; ?>" <?php echo $icon; ?> data-text="<?php echo $behavior['title']; ?>" data-label="<?php echo $behavior['title']; ?>" data-labelcolor="black" <?php echo $selected; ?> data-tooltip="<?php echo $behavior['desc']; ?>" data-config="<?php echo (int)$behavior['has_config']; ?>"><?php echo $behavior['desc']; ?></option>
					<?php endforeach; ?>
				<?php //endforeach; ?>
			</select>
			<small><?php echo $desc; ?></small>
		</div>
		<div class="ui container fluid behaviors_config_area">
		<?php
			if(count($this->data('Connection.'.$utype.'.'.$n.'.behaviors.'.$group, []))){
				$selected_behaviors = $this->data('Connection.'.$utype.'.'.$n.'.behaviors.'.$group, []);
			}
			
			if(count($selected_behaviors)){
				foreach($accepted as $behavior){
					if(in_array($behavior['name'], $selected_behaviors)){
						$this->view(dirname(__FILE__).DS.'behavior_config.php', ['utype' => $utype, 'n' => $n, 'behavior' => $behavior, 'unit' => $unit]);
					}
				}
			}
		?>
		</div>
	</div>
	<?php } ?>