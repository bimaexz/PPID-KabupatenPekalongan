<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
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
<div class="ui menu small inverted g3Color4 G3-tabs">
	<!-- <a class="item white active" data-tab="views-list" data-send="views"><?php el3('Views'); ?></a>
	<a class="item white contact-hidden" data-tab="functions-list" data-send="functions"><?php el3('Actions'); ?></a> -->
	<!-- <div class="item" style="width:50%;">
		<div class="ui input tiny"><input type="text" placeholder="Search..."></div>
	</div> -->
	<div class="item right">
		<button type="button" class="ui button green icon tiny toolbar-button" data-fn="saveform" name="apply" data-url="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=edit&apply=1'); ?>" data-hint="<?php el3('Full Save'); ?>">
			<i class="save icon"></i>
		</button>
		<?php if(!empty($this->data['Connection']['id'])): ?>
		&nbsp;
		<button type="button" class="ui button blue icon tiny" data-fn="saveform" name="apply" data-apply="1" data-url="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=edit&tvout=view&apply=1'); ?>" data-hint="<?php el3('Quick Save'); ?>">
			<i class="check icon"></i>
		</button>
		<?php endif; ?>
	</div>
</div>
<?php
	$utypes = ['views', 'functions'];
	foreach($utypes as $utype):
?>
	<!-- <div class="ui container fluid tab unitsList <?php if($utype == 'views'): ?>active<?php endif; ?>" data-name="<?php echo $utype; ?>" data-tab="<?php echo $utype; ?>-list"> -->
		<?php
			//get views files
			$units = \G3\L\Folder::getFolders(\G3\Globals::ext_path('chronoforms', 'admin').$utype.DS);
			$units_info = [];
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
				$units_info[$name] = $info;
			}
			// $types = ['core', 'more'];
			// $units_info2 = ['core' => $units_info];//, 'more' => $blocks_views];
			
			if($utype == 'views'){
				$units_groups = [
					rl3('Fields'),
					rl3('Advanced Fields'),
					rl3('Security Fields'),
					rl3('Areas'),
					rl3('Custom'),
					rl3('Page Blocks'),
				];
			}else{
				$units_groups = [
					rl3('Basics'),
					rl3('Database'),
					rl3('Advanced'),
					//rl3('Joomla'),
					//rl3('Files'),
					rl3('Payments'),
				];
				
				if(\G3\Globals::get('app') == 'joomla'){
					$units_groups[] = rl3('Joomla');
				}
			}
		?>
		
		<?php //foreach($types as $kt => $type): ?>
		<div class="ui bottom attached tab accordion1 <?php if($utype == 'views'): ?>active<?php endif; ?>" data-name="<?php echo $utype; ?>" data-tab="<?php echo $utype; ?>-list">
			<!-- <div class="ui fluid accordion1 segment inverted quti bg-cfpcolor draggable-list" style="overflow-y:auto;"> -->
			<div class="ui vertical menu fluid inverted g3Color4">
				<?php foreach($units_groups as $kvg => $units_group): ?>
					<div class="item">
						<div class="header center aligned" style="border:0;padding:0;">
						<!-- <i class="dropdown icon"></i> -->
						<?php echo $units_group; ?>
						</div>
						<div class="menu">
							
							<!-- <div class="ui grid center aligned small views-list"> -->
								<?php foreach($units_info as $vw_name => $vw_info): ?>
									<?php if($vw_info['group'] == $units_group): ?>
									<div class="item draggable" data-utype="<?php echo $utype; ?>" data-info='<?php echo json_encode($vw_info); ?>'  data-url="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=unit_config&tvout=view'); ?>">
									<!-- <div class="sixteen wide column draggable" data-utype="<?php echo $utype; ?>" data-info='<?php echo json_encode($vw_info); ?>' style="padding:5px;" data-url="<?php echo r3('index.php?ext=chronoforms&cont=connections&act=unit_config&tvout=view'); ?>"> -->
										<div class="ui button fluid inverted icon active small compact labeled" <?php if(!empty($vw_info['desc'])): ?>data-hint="<?php echo nl2br($vw_info['desc']); ?>"<?php endif; ?>>
											<?php if(!empty($vw_info['icon'])): ?>
											<i class="icon <?php echo $vw_info['icon']; ?> fitted"></i>
											<?php endif; ?>
											<?php echo $vw_info['title']; ?>
										</div>
									<!-- </div> -->
									</div>
									<?php endif; ?>
								<?php endforeach; ?>
							<!-- </div> -->
							
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<!-- </div> -->
		</div>
		<?php //endforeach; ?>
		
	<!-- </div> -->
<?php endforeach; ?>