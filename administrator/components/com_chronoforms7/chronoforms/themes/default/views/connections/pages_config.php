<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$hidden = '';
	if(!empty($this->data('Connection.pages.'.$pcount.'.minimized'))){
		$hidden = ' hidden';
	}
?>
<div class="ui container fluid pages-tab main-event main-area area pagesList" data-count="<?php echo $pcount; ?>" data-name="<?php echo $page['name']; ?>" data-title="<?php echo $pgroup['name']; ?>.<?php echo $page['name']; ?>" style="margin:0 0 0.5em 0;">
	<!-- <input type="hidden" value="<?php echo $page['name']; ?>" name="Connection[pages][<?php echo $pcount; ?>][name]" readonly="true"> -->
	<input type="hidden" value="<?php echo $pgcount; ?>" name="Connection[pages][<?php echo $pcount; ?>][pgroup]" class="page_pgroup">
	<input type="hidden" value="0" name="Connection[pages][<?php echo $pcount; ?>][minimized]" class="page_minimized">
	
	<div class="ui menu small text three item top attached quti bg-white G3-tabs" style="margin-top:0;">
		<div class="menu item" style="justify-content:start;">
			<div class="item title" data-tab="pages-<?php echo $pcount; ?>-title">
				<label class="ui label quti bg-black text-white py-2 px-3 rounded-full"><?php el3('Page'); ?>:<?php echo $pcount; ?></label>
			</div>

			<div class="item title" data-tab="pages-<?php echo $pcount; ?>-title" data-name="title" data-hint="<?php el3('The name of this page'); ?>">
				<div class="ui compact header" style="margin:0;">
					<div class="content">
						<?php echo $page['name']; ?>
						<!-- <div class="sub header"><?php echo $page['description'] ?? ''; ?></div> -->
					</div>
				</div>
			</div>
		</div>
		
		<div class="menu item" style="justify-content:center;">
			<?php if($this->data("Connection.apptype") == "connectivity"): ?>
				<a class="item white active toggle_designer<?php //echo $hidden; ?>" data-tab="pages-<?php echo $pcount; ?>-content" data-name="content" data-hint="<?php el3('The page code'); ?>"><i class="faicon code"></i><?php echo el3('Content'); ?></a>
			<?php else: ?>
				<a class="item white active toggle_designer<?php //echo $hidden; ?>" data-tab="pages-<?php echo $pcount; ?>-units" data-name="units" data-hint="<?php el3('The views and actions of this page'); ?>"><i class="faicon boxes"></i><?php echo el3('Units'); ?></a>
			<?php endif; ?>
			
			<a class="item<?php //echo $hidden; ?> red contact-hidden" data-tab="pages-<?php echo $pcount; ?>-settings"><i class="faicon wrench"></i><?php el3('Settings'); ?></a>
			
			<?php if($this->data("Connection.apptype") != "connectivity"): ?>
				<a class="item<?php //echo $hidden; ?> orange preview-tab" data-name="<?php echo $pcount; ?>" data-tab="pages-<?php echo $pcount; ?>-preview" data-hint="<?php el3('A quick preview of the page layout'); ?>" data-url="<?php echo r3('index.php?ext='.\GApp3::instance()->extension.'&cont=connections&act=preview_section&__section='.$pcount.'&form_id='.$this->data('Connection.id').'&tvout=view'); ?>"><i class="faicon tv"></i><?php el3('Preview'); ?></a>
			<?php endif; ?>
		</div>
		
		<div class="item" data-tab="pages-<?php echo $pcount; ?>-tools" style="justify-content:end;">
			<i class="faicon compress-alt white link collapse_area" data-hint="<?php el3('Collapse All'); ?>"></i>
			<i class="faicon window-<?php if(!empty($this->data('Connection.pages.'.$pcount.'.minimized'))):?>maximize<?php else: ?>minimize<?php endif; ?> teal link minimize_area minimize_page" data-hint="<?php el3('Minimize/Maximize'); ?>"></i>
			
			<a target="_blank" href="<?php echo r3('index.php?ext=chronoforms&cont=manager&chronoform='.$this->data('Connection.alias', '').'&gpage='.$page['name']); ?>"><i class="faicon link blue link" data-hint="<?php el3('Page Link'); ?>"></i></a>
			<i class="faicon sort yellow link sort_area" data-hint="<?php el3('Sort'); ?>"></i>
			<i class="faicon times red link delete_area" data-hint="<?php el3('Delete'); ?>"></i>
		</div>
		
	</div>

	<?php if(!empty($page['description'])): ?>
		<div class="ui segment attached" >
			<?php echo $page['description']; ?>
		</div>
	<?php endif; ?>

	<?php if($this->data("Connection.apptype") == "connectivity"): ?>
		<div class="ui tab active<?php echo $hidden; ?> content segment bottom attached" data-name="<?php echo $pcount; ?>" data-tab="pages-<?php echo $pcount; ?>-content" style="padding:5px 5px 5px 5px;">
			<div class="ui segment">
				<textarea name="Connection[pages][<?php echo $pcount; ?>][content]" rows="15" data-codeeditor='{"mode":"php"}'></textarea>
			</div>
		</div>
	<?php else: ?>
		<div class="ui tab active<?php echo $hidden; ?> units segment bottom attached" data-name="<?php echo $pcount; ?>" data-tab="pages-<?php echo $pcount; ?>-units" style="padding:5px 5px 5px 5px;">
			<?php
				$this->view('views.connections.views_actions_editor', [
					'functions' => $functions ?? [], 
					'views' => $views ?? [],
					'pcount' => $pcount,
				]);
			?>
		</div>
	<?php endif; ?>
	
	<div class="ui tab <?php echo $hidden; ?> segment bottom attached" data-tab="pages-<?php echo $pcount; ?>-settings">
		<!-- <div class="field">
			<label><?php el3('Page Type'); ?></label>
			<select name="Connection[pages][<?php echo $page['name']; ?>][type]" class="ui fluid dropdown">
				<option value=""><?php el3('Auto - Use page order'); ?></option>
				<option value="standalone"><?php el3('Standalone'); ?></option>
				<option value="end"><?php el3('End'); ?></option>
			</select>
			<small><?php el3('Select the page type.'); ?></small>
		</div> -->
		<div class="ui message top attached">
			<div class="fields">
				<div class="six wide field">
					<label><?php el3('Page Name'); ?></label>
					<input type="text" value="<?php echo $page['name']; ?>" name="Connection[pages][<?php echo $pcount; ?>][name]" class="pagename" />
				</div>
				<div class="ten wide field">
					<label><?php el3('Page Description'); ?></label>
					<input type="text" value="<?php echo $page['description'] ?? ''; ?>" name="Connection[pages][<?php echo $pcount; ?>][desc]" />
				</div>
			</div>
		</div>
		<?php $this->view($this->get('cf.paths.shared').'behaviors_list.php', ['glist' => ['html', 'data'], 'unit' => ['utype' => 'pages', 'type' => 'page', 'uid' => $pcount]]); ?>
	</div>
	
	<div class="ui tab  segment bottom attached<?php echo $hidden; ?>" data-tab="pages-<?php echo $pcount; ?>-preview" data-preview="<?php echo $pgroup['name']; ?>::<?php echo $page['name']; ?>">
		
	</div>
	
</div>