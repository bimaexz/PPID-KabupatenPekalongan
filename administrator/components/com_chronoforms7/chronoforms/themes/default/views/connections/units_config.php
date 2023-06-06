<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($area) AND $area == $unit['_area']){
		return;
	}

	// if(!empty($unit) AND empty($unit['name'])){
	// 	return;
	// }

	$unit['name'] = !empty($unit['name']) ? $unit['name'] : $type.$count;

	$unit_path = \G3\Globals::ext_path('chronoforms', 'admin').$utype.DS.$type.DS.$type.'_config.php';
	$ini_path = \G3\Globals::ext_path('chronoforms', 'admin').$utype.DS.$type.DS.$type.'.php';

	if(!file_exists($unit_path)){
		$this->data['Connection'][$utype][$count]['type'] = $type = 'generic';
		$unit_path = \G3\Globals::ext_path('chronoforms', 'admin').$utype.DS.$type.DS.$type.'_config.php';
		$ini_path = \G3\Globals::ext_path('chronoforms', 'admin').$utype.DS.$type.DS.$type.'.php';
	}

	//$label_path = \G3\Globals::ext_path('chronoforms', 'admin').'__shared'.DS.'unit_name_config.php';
	
	$info = require($ini_path);
	
	$icon_color = 'green';
	if(isset($unit['enabled']) AND empty($unit['enabled'])){
		$icon_color = 'red';
	}
	
	$unit['info'] = $info;

	$color =  ($utype == 'views') ? 'teal' : 'purple';

	$wtitle = $info['title'].' '.$count;
	if(!empty($unit['wtitle'])){
		$wtitle = $unit['wtitle'];
	}else if(!empty($unit['nodes']['label']['content']) AND !empty(trim($unit['nodes']['label']['content']))){
		$wtitle = $unit['nodes']['label']['content'];
	}else if(!empty($unit['nodes']['main']['content']) AND $unit['type'] == 'field_button'){
		$wtitle = $unit['nodes']['main']['content'];
	}
	$wtitle = htmlspecialchars($wtitle);

	$listClasses = '';
	foreach(($info['ugroups'] ?? []) as $ugroup){
		$listClasses .= $ugroup.'List ';
	}

	$safe_mode = false;
	if(!empty($starting_unit) AND !empty($this->get('cf_settings.formeditor.safe_mode', true)) AND ($this->data('act') != 'demos')){
		$safe_mode = true;
	}
?>
<div class="ui segment <?php echo $color; ?> dragged <?php echo $utype; ?>List <?php echo $listClasses; ?>" data-utype="<?php echo $utype; ?>" data-type="<?php echo $type; ?>" data-count="<?php echo $count; ?>" data-title="<?php echo $wtitle; ?>" data-uicon="<?php echo $info['icon']; ?>" data-url="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=unit_load&utype='.$utype.'&uid='.$count.'&Connection[id]='.$this->data('Connection.id').'&tvout=view'); ?>" style="margin:5px 0px; padding:5px 10px;">
	<label class="ui label quti text-white bg-<?php echo $color; ?> unit-title" data-hint="<?php echo $unit['name']; ?>">
		<i class="faicon <?php echo $info['icon']; ?> <?php echo ((!$this->get('__valid') AND !empty($info['paid'])) ? 'red' : ''); ?>"></i>
		<?php echo $info['title']; ?>
		
		<div class="detail"><?php echo $wtitle; ?></div>
	</label>
	
	<div class="ui label icon unit_events hidden" data-hint="<?php el3('This field has events'); ?>"><i class="faicon bell"></i></div>

	<?php if(true)://$utype == 'functions' OR $this->data('Connection.apptype') == 'connectivity'): ?>
	<div class="ui label dragged_name black"><?php echo $unit['name']; ?></div>
	<?php endif; ?>
	
	<?php if(!empty($unit['nodes']['main']['attrs']['name'])): ?>
		<div class="ui label quti bg-black text-white"><?php echo $unit['nodes']['main']['attrs']['name']; ?></div>
	<?php endif; ?>

	<?php if(!empty($info['dependencies'])): ?>
		<?php foreach($info['dependencies'] as $dep => $msg): ?>
			<?php if(!file_exists($dep)): ?>
				<div class="ui label quti bg-red text-white"><?php echo $msg; ?></div>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	
	<div class="dragged_actions">
		<i class="faicon times red link delete_dragged dragged_action hidden" data-hint="<?php el3('Delete'); ?>"></i>
		
		<?php //if(!$safe_mode): ?>
		<i class="faicon copy green link copy_dragged dragged_action hidden <?php if($safe_mode): ?>safe_mode<?php endif; ?>" data-hint="<?php el3('Copy'); ?>" data-url="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=copy_element&utype='.$utype.'&tvout=view'); ?>"></i>
		<?php //endif; ?>
		
		<i class="faicon sort orange link sort_dragged dragged_action hidden" data-hint="<?php el3('Sort'); ?>"></i>
		
		<i class="faicon cog black link dragged_action edit_dragged <?php if($safe_mode): ?>safe_mode<?php endif; ?>" data-hint="<?php el3('Edit'); ?>"></i>
	</div>

	<?php $this->view('views.connections.units_config_area', ['utype' => $utype, 'type' => $type, 'count' => $count, 'unit' => $unit, 'safe_mode' => $safe_mode]); ?>
	
	<?php
		$areas = 'areas';

		if(!empty($unit[$areas])){
			if(is_array($unit[$areas])){
				$u_areas = [];
				foreach($unit[$areas] as $k => $event){
					if(!empty($event['name'])){
						if(!in_array($event['name'], \G3\L\Arr::getVal($u_areas, ['[n]', 'name']))){
							if(!isset($event['enabled']) OR (isset($event['enabled']) AND !empty($event['enabled']))){
								if(!empty($event['before'])){
									foreach($event['before'] as $bname => $bvalue){
										$u_areas[] = ['name' => str_replace('{name}', $event['name'], $bvalue), 'color' => 'blue'];
									}
								}
								$u_areas[] = ['name' => $event['name'], 'color' => 'blue'];
							}
						}
					}
				}
			}
		}else if(!empty($info['areas'])){
			foreach($info['areas'] as $ename => $ecolor){
				$u_areas[] = ['name' => $ename, 'color' => $ecolor];
			}
		}else{
			$u_areas = [];

			if($type == 'generic'){
				if(!empty($units)){
					foreach($units as $un => $_unit){
						if(!empty($_unit['_parent']) AND ($_unit['_parent'] == $count)){
							if(!in_array($_unit['_area'], \G3\L\Arr::getVal($u_areas, ['[n]', 'name']))){
								$u_areas[] = ['name' => $_unit['_area'], 'color' => 'blue'];
							}
						}
					}
					// $u_areas = array_unique($u_areas);
				}
			}
		}
	?>
	<?php if(!empty($u_areas)): ?>
		<div class="ui segments dragged-areas fluid">
		<?php foreach($u_areas as $ek => $_area): ?>
			<div class="ui segment quti bg-<?php echo $_area['color']; ?>200 unit_area draggable-receiver" data-receive="<?php echo $utype; ?>" style="min-height:50px; padding-top:3px;" data-area="<?php echo $_area['name']; ?>" data-count="<?php echo $count; ?>" data-areakey="<?php echo $ek; ?>">
				<div class="ui label ribbon quti text-white bg-<?php echo $_area['color']; ?> draggable-receiver-title7 minimize_area" style="" data-area="<?php echo $_area['name']; ?>" data-count="<?php echo $count; ?>" data-areakey="<?php echo $ek; ?>">
					<?php if($utype == 'functions'): ?>
						<i class="faicon bolt"></i>
					<?php else: ?>
						<i class="faicon regular:square"></i>
					<?php endif; ?>
					<?php echo $_area['name']; ?>
				</div>
				<?php if(!empty($units)): ?>
					<?php foreach($units as $un => $_unit): ?>
						<?php if(($_unit['_area'] == $_area['name']) AND ($_unit['_parent'] == $count)): ?>
							<?php $this->view('views.connections.units_config', ['utype' => $_unit['utype'], 'type' => $_unit['type'], 'count' => $un, 'unit' => $_unit, 'units' => $units, 'starting_unit' => $starting_unit ?? false]); ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>