<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui container fluid pgroup" style="margin:0 0 0.5em 0;" data-count="<?php echo $pgcount; ?>" data-title="<?php echo $pgroup['name']; ?>">
	<!-- <input type="hidden" value="<?php echo $pgroup['name']; ?>" name="Connection[pgroups][<?php echo $pgcount; ?>][name]" readonly="true"> -->

	<div class="ui top attached inverted menu secondary small G3-tabs quti bg-indigo800 text-white" style="margin-top:0;">
		<div class="item title" data-tab="pgroups-<?php echo $pgcount; ?>-title" data-hint="<?php el3('a page group is a set of pages with specific order, type and display area'); ?>">
			<label class="ui label quti bg-indigo text-white py-2 px-3 rounded-full" style="z-index:1005;"><?php el3('Page Group'); ?></label>
		</div>
		<div class="item title" data-tab="pgroups-<?php echo $pgcount; ?>-title" data-name="title" data-hint="<?php el3('The name of this page group'); ?>">
			<div class="ui compact header inverted small" style="margin:0;"><?php echo $pgroup['name']; ?></div>
		</div>

		<a class="item white active" data-tab="pgroup-<?php echo $pgcount; ?>-pages" data-hint="<?php el3('Pages included in this page group'); ?>"><i class="faicon copy"></i><?php echo el3('Pages'); ?></a>
		
		<a class="item white contact-hidden" data-tab="pgroup-<?php echo $pgcount; ?>-settings" data-hint="<?php el3('Page group settings'); ?>"><i class="faicon wrench"></i><?php echo el3('Settings'); ?></a>

		<div class="item right" data-tab="pgroup-<?php echo $pgcount; ?>-type">
			<?php el3('Type:'); ?>&nbsp;
			<select name="Connection[pgroups][<?php echo $pgcount; ?>][type]" class="ui fluid dropdown inline" data-rich="1" placeholder="">
				<option value="" data-html='<i class="faicon sync"></i>'><?php el3('Sequential'); ?></option>
				<option value="standalone" data-html='<i class="faicon file"></i>'><?php el3('Standalone'); ?></option>
				<option value="private" data-html='<i class="faicon archive"></i>'><?php el3('Private'); ?></option>
			</select>
		</div>
		<div class="item right" data-tab="pgroup-<?php echo $pgcount; ?>-site">
			<?php el3('Site:'); ?>&nbsp;
			<select name="Connection[pgroups][<?php echo $pgcount; ?>][site]" class="ui fluid dropdown inline" data-rich="1" placeholder="">
				<option value=""><?php el3('All'); ?></option>
				<option value="front" data-html='<i class="faicon globe"></i>'><?php el3('Frontend'); ?></option>
				<option value="admin" data-html='<i class="faicon user-secret"></i>'><?php el3('Backend'); ?></option>
			</select>
		</div>
		<div class="item right" data-tab="pgroup-<?php echo $pgcount; ?>-tools">
			<i class="faicon file alternate white link add-page" data-url="<?php echo r3('index.php?ext='.\GApp3::instance()->extension.'&cont=connections&act=pages_config&pgroup[name]='.$pgroup['name'].'&newpage[pgroup]='.$pgcount.'&pgcount='.$pgcount.'&Connection[apptype]='.$this->data('Connection.apptype').'&tvout=view'); ?>" data-hint="<?php el3('Add New Page'); ?>"></i>
			
			<i class="faicon window-<?php if(!empty($this->data('Connection.pgroups.'.$pgcount.'.minimized'))):?>maximize<?php else: ?>minimize<?php endif; ?> teal link minimize_pgroup minimize_page" data-hint="<?php el3('Minimize/Maximize'); ?>" data-named="<?php echo $pgcount; ?>"></i>
			
			<i class="faicon sort yellow link sort_pgroup" data-hint="<?php el3('Sort'); ?>"></i>
			<i class="faicon times red link delete_pgroup" data-hint="<?php el3('Delete'); ?>"></i>
		</div>
	</div>
	<div class="ui divider fitted quti bg-indigo800"></div>
	<div class="ui segment secondary areas bottom attached tab active quti bg-indigo800 border-0" data-tab="pgroup-<?php echo $pgcount; ?>-pages">
		<?php foreach($pages as $page_name => $page): ?>
			<?php
				if($page['pgroup'] == $pgcount){
					$this->view('views.connections.pages_config', [
						'pgroup' => $pgroup,
						'page' => $page, 
						'pcount' => $page_name, 
						'pgcount' => $pgcount, 
						//'units' => array_merge($this->data('Connection.functions', []), $this->data('Connection.views', [])),
						'functions' => $this->data('Connection.functions', []), 
						'views' => $this->data('Connection.views', []),
					]);
				}
			?>
		<?php endforeach; ?>
	</div>
	<div class="ui segment secondary bottom attached tab quti bg-indigo800 border-0" data-tab="pgroup-<?php echo $pgcount; ?>-settings">
		<div class="ui message top attached">
			<div class="equal width fields">
				<div class="field">
					<label><?php el3('PageGroup Name'); ?></label>
					<input type="text" value="<?php echo $pgroup['name']; ?>" name="Connection[pgroups][<?php echo $pgcount; ?>][name]" class="pgroupname" />
				</div>
				<!-- <div class="field">
					<label><?php el3('PageGroup Type'); ?></label>
					<select name="Connection[pgroups][<?php echo $pgcount; ?>][type]" class="ui fluid dropdown" placeholder="">
						<option value=""><?php el3('Sequential - Ordered pages'); ?></option>
						<option value="standalone"><?php el3('Standalone - Independent pages'); ?></option>
						<option value="private"><?php el3('Private - Units storage'); ?></option>
					</select>
					<small><?php el3('Select the page type.'); ?></small>
				</div> -->
			</div>
		</div>
	</div>
</div>