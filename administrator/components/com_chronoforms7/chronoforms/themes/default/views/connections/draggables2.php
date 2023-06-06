<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$utypes = ['views', 'functions'];
	$units_info = [];
	$units_groups = [];
	foreach($utypes as $utype){
		//get views files
		$units = \G3\L\Folder::getFolders(\G3\Globals::ext_path('chronoforms', 'admin').$utype.DS);
		foreach($units as $unit){
			$name = basename($unit);
			$info_file = $unit.DS.$name.'.php';
			if(!file_exists($info_file)){
				continue;
			}
			$info = require($info_file);
			
			if(!empty($info['apps'])){
				if(!in_array($this->data('Connection.apptype'), $info['apps'])){
					continue;
				}
			}
			if(!isset($info['color'])){
				$info['color'] = 'blue';
			}
			if(!empty($info['private']) AND !empty($public)){
				continue;
			}
			if(!empty($info['platform']) AND !in_array(\G3\Globals::get('app'), $info['platform'])){
				continue;
			}
			$units_info[$utype][$name] = $info;

			$units_groups[$utype][$info['group']][] = $name;
		}

	}
?>
<!-- <div class="ui message center aligned top attached" style="border:5px solid #321891; border-bottom:0;">
	<?php if(!empty($this->data['Connection']['id'])): ?>
	<button type="button" class="ui button compact blue icon labeled tiny" data-fn="saveform" name="apply" data-apply="1" data-url="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=edit&tvout=view&apply=1'); ?>" data-hint="<?php el3('Save form changes without reloading the form editor interface'); ?>">
		<i class="check icon"></i><?php el3('Apply'); ?>
	</button>
	<?php endif; ?>
	<button type="button" class="ui button compact green icon labeled tiny toolbar-button" data-fn="saveform" name="apply" data-url="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=edit&apply=1'); ?>" data-hint="<?php el3('Save form changes and reload the form editor interface to apply any new changes'); ?>">
		<i class="save icon"></i><?php el3('Save'); ?>
	</button>
</div> -->
<div class="ui menu small inverted teal G3-tabs">
	<!-- <a class="item white active" data-tab="views-list" data-send="views"><?php el3('Views'); ?></a>
	<a class="item white contact-hidden" data-tab="functions-list" data-send="functions"><?php el3('Actions'); ?></a> -->
	<!-- <div class="item" style="width:50%;">
		<div class="ui input tiny"><input type="text" placeholder="Search..."></div>
	</div> -->
	<?php foreach($units_groups as $utype => $ugroups): ?>
		<div class="item menu_header <?php if($utype != 'views'): ?>hidden<?php endif; ?>" data-utype="<?php echo $utype; ?>">
			<h4 class="ui header inverted small"><?php echo ($utype != 'views') ? rl3('Actions') : rl3('Views'); ?></h4>
		</div>
	<?php endforeach; ?>
	<div class="right menu">
		<?php foreach($units_groups as $utype => $ugroups): ?>
			<?php foreach($ugroups as $ugroup => $group_units): ?>
			<?php
				if(in_array($ugroup, ['Joomla', 'WordPress'])){
					if(strtolower($ugroup) != \G3\Globals::get('app')){
						continue;
					}
				}
			?>
			<div class="ui dropdown item <?php if($utype != 'views'): ?>hidden<?php endif; ?>" data-utype="<?php echo $utype; ?>" data-action="nothing">
					<span class="ui text large"><?php echo $ugroup; ?></span><i class="faicon angle-down quti ml-2"></i>
					<div class="menu">
						<?php foreach($group_units as $name): ?>
							<div class="item draggable" data-utype="<?php echo $utype; ?>" data-info='<?php echo json_encode($units_info[$utype][$name]); ?>'  data-url="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=unit_config&tvout=view&Connection[id]='.$this->data('Connection.id')); ?>" style="padding:1px 2px !important;">
								<div class="ui button icon labeled fluid small black" <?php if(!empty($units_info[$utype][$name]['desc'])): ?>data-hint="<?php echo nl2br($units_info[$utype][$name]['desc']); ?>"<?php endif; ?>>
									<?php if(!empty($units_info[$utype][$name]['icon'])): ?>
									<i class="faicon <?php echo $units_info[$utype][$name]['icon']; ?> <?php echo ((!$this->get('__valid') AND !empty($units_info[$utype][$name]['paid'])) ? 'red' : ''); ?> fitted"></i>
									<?php endif; ?>
									<?php echo $units_info[$utype][$name]['title']; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endforeach; ?>
		<div class="item">
			<!-- <button type="button" class="ui button green icon tiny toolbar-button" data-fn="saveform" name="apply" data-url="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=edit&apply=1'); ?>" data-hint="<?php el3('Full Save'); ?>">
				<i class="save icon"></i>
			</button>
			&nbsp; -->
			<?php if(!empty($this->data['Connection']['id'])): ?>
			<button type="button" class="ui button blue icon tiny labeled" data-fn="saveform" name="apply" data-apply="1" data-url="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=edit&tvout=json&apply=1'); ?>" data-hint="<?php el3('Quick Save'); ?>">
				<?php el3('Apply'); ?><i class="faicon check"></i>
			</button>
			<a class="ui button tiny icon quti bg-white text-grey800 p-2 ml-1" href="<?php echo r3('index.php?ext=chronoforms&cont=manager&chronoform='.$this->data('Connection.alias', '')); ?>" data-hint="<?php el3('Admin View'); ?>" target="_blank">
				<i class="faicon user-secret"></i>
			</a>
			<a class="ui button tiny icon quti bg-white text-grey800 p-2 ml-1" href="<?php echo r3(\G3\Globals::get('ROOT_URL').'index.php?ext=chronoforms&cont=manager&chronoform='.$this->data('Connection.alias', '')); ?>" data-hint="<?php el3('Front View'); ?>" target="_blank">
				<i class="faicon globe"></i>
			</a>
			<?php endif; ?>
		</div>
	</div>
</div>