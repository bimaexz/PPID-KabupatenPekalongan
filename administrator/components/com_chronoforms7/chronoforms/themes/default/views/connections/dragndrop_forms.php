<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui container fluid">
	<?php
		$maxu_counter = 0;
		if(!empty($this->data['Connection']['functions'])){
			$maxu_counter = max(array_keys($this->data['Connection']['functions']));
		}
		if(!empty($this->data['Connection']['views'])){
			if(max(array_keys($this->data['Connection']['views'])) > $maxu_counter){
				$maxu_counter = max(array_keys($this->data['Connection']['views']));
			}
		}
		$maxu_counter += 1;
	?>
	<input type="hidden" value="<?php echo $maxu_counter; ?>" id="units-count" name="units-count">

	<div class="ui message violet toast" id="unitTitleToast">
		<div class="content">
			<div class="ui form">
				<div class="field">
					<label><?php el3('Unit Title'); ?></label>
					<input type="text" value="" class="unit-title-label" style="width:90%">
				</div>
				<div class="field">
					<label><?php el3('Unit Name'); ?></label>
					<input type="text" value="" class="unit-name-label" style="width:90%">
				</div>
			</div>
		</div>
	</div>

	<div class="ui message yellow inverted toast" id="pageGroupDelete">
		<div class="content">
			<div class="ui header red"><?php el3('Warning'); ?></div>
			<?php el3('Do you really want to delete this Page Group and all included Pages and Units?'); ?>
		</div>
		<div class="left basic actions">
			<button class="ui positive red button"><?php el3('Yes'); ?></button>
			<button class="ui negative button"><?php el3('No'); ?></button>
		</div>
	</div>

	<div class="ui message yellow inverted toast" id="pageDelete">
		<div class="content">
			<div class="ui header red"><?php el3('Warning'); ?></div>
			<?php el3('Do you really want to delete this page and all included Units?'); ?>
		</div>
		<div class="left basic actions">
			<button class="ui positive red button"><?php el3('Yes'); ?></button>
			<button class="ui negative button"><?php el3('No'); ?></button>
		</div>
		<br />
		<?php el3('Please note that, if your form has one page only then some features may not work correctly!'); ?>
	</div>
	
	<div class="three wide column scrollableBox hidden">
		<div class="ui fluid container unitsContainer2" id="unitsContainer2">
			<?php //$this->view(dirname(__FILE__).DS.'draggables.php'); ?>
		</div>
	</div>
	
	<div class="column">
		<?php if($this->data("Connection.apptype") != "connectivity"): ?>
		<div class="ui fluid container unitsContainer" id="unitsContainer" style="z-index:1010;">
			<?php $this->view(dirname(__FILE__).DS.'draggables2.php'); ?>
		</div>
		<?php endif; ?>
		<div class="pgroups" style="margin-top:5px;">
			<?php
				if(!empty($this->data['Connection']['pgroups'])){
					foreach($this->data['Connection']['pgroups'] as $pgcount => $pgroup){
						if(strpos($pgroup['name'], '-connectivity') !== false){
							continue;
						}
						$this->view('views.connections.pgroup_config', [
							'pgcount' => $pgcount,
							'pgroup' => $pgroup, 
							'pages' => $this->data['Connection']['pages'] ?? [],
						]);
					}
				}
			?>
		</div>
		<div class="ui form segment inverted contact-hidden quti bg-blue600">
			<?php
				$maxp_counter = 0;
				if(!empty($this->data['Connection']['pages'])){
					$maxp_counter = max(array_keys($this->data['Connection']['pages']));
				}
				$maxp_counter += 1;
			?>
			<input type="hidden" value="<?php echo $maxp_counter; ?>" id="pages-count" name="pages-count">

			<?php
				$maxpg_counter = 0;
				if(!empty($this->data['Connection']['pgroups'])){
					$maxpg_counter = max(array_keys($this->data['Connection']['pgroups']));
				}
				$maxpg_counter += 1;
			?>
			<input type="hidden" value="<?php echo $maxpg_counter; ?>" id="pgroups-count" name="pgroups-count">
			
			<div class="fields">
				<div class="ten wide field">
					<label><?php el3('Page Group Name'); ?></label>
					<input type="text" name="pgroup[name]" class="pgroup-name">
					<small><?php el3('Must be unique'); ?></small>
				</div>
				<!-- <div class="field contact-hidden">
					<label><?php el3('Page Group'); ?></label>
					<select name="page[pgroup]" class="ui fluid dropdown search page-pgroup" data-allowadditions="1">
						<?php foreach($this->data['Connection']['pgroups'] as $pgcount => $pgroup): ?>
							<option value="<?php echo $pgcount; ?>::<?php echo $pgroup['name']; ?>"><?php echo $pgroup['name']; ?></option>
						<?php endforeach; ?>
					</select>
					<small><?php el3('Choose one or add new one'); ?></small>
				</div> -->
				<div class="six wide field">
					<label>&nbsp;</label>
					<button type="button" class="ui button green fluid icon labeled disabled add-pgroup" disabled data-url="<?php echo r3('index.php?ext='.\GApp3::instance()->extension.'&cont=connections&act=pages_config&Connection[apptype]='.$this->data('Connection.apptype').'&tvout=view'); ?>">
						<i class="faicon map"></i><?php el3('Add New Page Group'); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>