<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	ob_start();
?>
	jQuery(document).ready(function($) {
		$('.dropdown.G3-options').each(function(i, field){
			$(field).dropdown({
				apiSettings: {
					url: $(field).data('url'),
					cache:false
				},
				saveRemoteData:false
			});
		});
	});
<?php
	$jscode = ob_get_clean();
	\GApp3::document()->addJsCode($jscode);
	\GApp3::document()->_('tinymce');
	\GApp3::document()->addJsCode('jQuery(document).ready(function($){$.G3.tinymce.init();});');
	$this->view(\G3\Globals::ext_path('chronoforms', 'admin').DS.'themes'.DS.'default'.DS.'views'.DS.'designer.php');
?>
<?php
	$this->view('views.admin.page_menu', [
			'title' => rl3('Settings Manager'),
			'class' => 'quti bg-cfpcolor',
			'items' => [
				'general' => [
					'color' => 'violet',
					'active' => 'active',
					'icon' => 'cog',
					'title' => rl3('General'),
				],
				// 'apis' => [
				// 	'color' => 'violet',
				// 	'icon' => 'globe',
				// 	'title' => rl3('APIs'),
				// ],
				'globals' => [
					'color' => 'violet',
					'icon' => 'keyboard',
					'title' => rl3('Global Vars'),
				],
				'joomla_system' => [
					'color' => 'violet '.((\G3\Globals::get('app') != 'joomla') ? 'hidden' : ''),
					'icon' => 'laptop',
					'title' => rl3('Joomla System'),
				],
				// 'behaviors' => [
				// 	'color' => 'violet',
				// 	'icon' => 'clipboard list',
				// 	'title' => rl3('Behaviors'),
				// ],
			],
			'btns' => [
				[
					'color' => 'inverted active',
					'name' => 'apply',
					'url' => r3('index.php?ext=chronoforms&cont=tasks&act=save_settings'),
					'hint' => rl3('Save settings'),
					'icon' => 'check',
					'title' => rl3('Save'),
				],
			]
	]);
?>

<input type="hidden" name="Extension[id]" value="">

<div class="ui segment tab active bottom attached" data-tab="general">
	<div class="equal width fields">
		<div class="field">
			<label><?php el3('Default Form Editor Starting Page'); ?></label>
			<select name="Extension[settings][formeditor][home]" class="ui fluid dropdown">
				<option value="pages"><?php el3('Pages Editor'); ?></option>
				<option value="settings"><?php el3('Form Settings'); ?></option>
			</select>
			<small><?php el3('Select the default starting page for the form editor'); ?></small>
		</div>

		<div class="field">
			<label><?php el3('Safe Mode'); ?></label>
			<select name="Extension[settings][formeditor][safe_mode]" class="ui fluid dropdown" placeholder="">
				<option value="1"><?php el3('Enabled'); ?></option>
				<option value=""><?php el3('Disabled'); ?></option>
			</select>
			<small><?php el3('Enable the safe mode for quick form editing'); ?></small>
		</div>

		<div class="field">
			<label><?php el3('Legacy support'); ?></label>
			<select name="Extension[settings][legacy][]" multiple="" class="ui fluid dropdown multiple">
				<option value="cf5" selected="selected">ChronoForms v5</option>
			</select>
			<small><?php el3('List of classic forms extensions to support, using the form alias in the url in v7 will process the classic form'); ?></small>
		</div>
	</div>

	<div class="ui header purple dividing"><?php el3('Debugger'); ?></div>
	
	<div class="equal width fields">
		<div class="field">
			<label><?php el3('Debug User groups'); ?></label>
			<select name="Extension[settings][debug][user_groups][]" multiple="" class="ui fluid dropdown" data-clearable="1">
				<?php foreach($groups as $id => $title): ?>
				<option value="<?php echo $id; ?>"><?php echo $title; ?></option>
				<?php endforeach; ?>
			</select>
			<small><?php el3('Limit the debug data visiblity to the selected groups.'); ?></small>
		</div>

		<div class="field">
			<label><?php el3('Developer Mode Debug Data'); ?></label>
			<select name="Extension[settings][debug][dev_mode]" class="ui fluid dropdown" placeholder="">
				<option value=""><?php el3('Disabled'); ?></option>
				<option value="1"><?php el3('Enabled'); ?></option>
			</select>
			<small><?php el3('Enable the dev mode debug data'); ?></small>
		</div>
	</div>

	<div class="ui header purple dividing"><?php el3('Tags'); ?></div>
	
	<div class="equal width fields">
		<div class="field">
			<label><?php el3('Tags'); ?></label>
			<select name="Extension[settings][tags][]" multiple="" class="ui fluid dropdown search" data-allowadditions="1">
				<option value="Contact" selected="selected">Contact</option>
				<option value="Test" selected="selected">Test</option>
				<option value="Demo" selected="selected">Demo</option>
			</select>
			<small><?php el3('List of available form tags'); ?></small>
		</div>
	</div>

	<!-- <div class="ui header purple dividing"><?php el3('Translations'); ?></div>
	
	<div class="equal width fields">
		<div class="field">
			<label><?php el3('Fetch latest translations from ChronoEngine.com'); ?></label>
			<select name="Extension[settings][translations][fetch]" class="ui fluid dropdown" placeholder="">
				<option value=""><?php el3('Disabled'); ?></option>
				<option value="1"><?php el3('Enabled'); ?></option>
			</select>
			<small><?php el3('On the admin translations page, the latest online translations will be fetched from ChronoEngine.com'); ?></small>
		</div>
	</div> -->
	
	<div class="ui header purple dividing"><?php el3('Fields'); ?></div>
	
	<div class="equal width fields">
		<!-- <div class="field">
			<label><?php el3('Tooltip Icon class'); ?></label>
			<input type="text" name="Extension[settings][tooltip][class]" value="icon info circular blue inverted small">
			<small><?php el3('HTML class to control the appearance of the tooltips'); ?></small>
		</div> -->
		<div class="field">
			<label><?php el3('Tooltip Trigger'); ?></label>
			<select name="Extension[settings][tooltip][trigger]" class="ui fluid dropdown">
				<option value="hover"><?php el3('Hover'); ?></option>
				<option value="click"><?php el3('Click'); ?></option>
			</select>
			<small><?php el3('Select when to display the tooltips'); ?></small>
		</div>
	</div>
	
	<?php
		$functions = \G3\L\Folder::getFolders(\G3\Globals::ext_path('chronoforms', 'admin').'functions'.DS);
		$behaviors_info = [];
		foreach($functions as $function){
			$name = basename($function);
			if(file_exists($function.DS.$name.'_global_config.php')){
				$info = require_once($function.DS.$name.'.php');
				
				echo '<div class="ui header purple dividing">'.$info['title'].'</div>';
				$this->view($function.DS.$name.'_global_config.php');
			}
		}
	?>
	
	<!-- <div class="field">
		<label><?php el3('Google Maps API key'); ?></label>
		<input type="text" value="" name="Extension[settings][gmaps][apikey]">
		<small><?php el3('Your GMaps API key provided by Google'); ?></small>
	</div> -->
	
	
	
</div>

<div class="ui segment tab bottom attached" data-tab="globals">
	<?php $this->view(\G3\Globals::ext_path('chronoforms', 'admin').'__shared'.DS.'clonable'.DS.'clonable.php', [
			'groups' => ['globals'],
			'items' => !empty($this->data('Extension.settings.globals', [])) ? $this->data('Extension.settings.globals', []) : [],
			'btns' => ['globals' => ['main' => ['text' => rl3('Add Global Variable')]]],
			'inputs' => [
				'globals' => [
					'main' => [
						'r1' => [
							[
								'width' => 'five wide', 
								'params' => [
									'placeholder' => rl3('Var name'), 
									'origin' => ['name' => 'Extension[settings][globals][#globals#][name]']
								],
							],
							[
								'width' => 'eight wide', 
								'params' => [
									'placeholder' => rl3('Var value'), 
									'origin' => ['name' => 'Extension[settings][globals][#globals#][value]']
								],
							],
							[
								'width' => 'two wide', 
								'type' => 'btns',
								'btns' => [
									'add' => [],
									'delete' => [],
								]
							],
						],
					],
				],
			]
		]);
	?>
</div>

<div class="ui segment tab bottom attached" data-tab="joomla_system">
	<div class="ui header purple dividing"><?php el3('Plugin Shortcode'); ?></div>
	
	<div class="equal width fields">
		<div class="field">
			<label><?php el3('Supported Components'); ?></label>
			<select name="Extension[settings][system][shortcode][components][]" multiple="" class="ui fluid dropdown search" data-allowadditions="1">
				<option value="com_content" selected="selected">com_content</option>
			</select>
			<small><?php el3('List of components where calling the chronoforms7 shortcode will be supported'); ?></small>
		</div>
	</div>

	<div class="ui header purple dividing"><?php el3('Request Override'); ?></div>

	<?php $this->view(\G3\Globals::ext_path('chronoforms', 'admin').'__shared'.DS.'clonable'.DS.'clonable.php', [
			'groups' => ['url_conditions'],
			'items' => $this->data('Extension.settings.system.url_conditions') ?? null,
			'btns' => ['url_conditions' => ['main' => ['text' => rl3('Add New Request Condition')]]],
			'inputs' => [
				'url_conditions' => [
					'main' => [
						'r1' => [
							[
								'width' => 'ten wide', 
								'params' => [
									'placeholder' => rl3('New Request Parameters'), 
									'origin' => ['name' => 'Extension[settings][system][url_conditions][#url_conditions#][params]']
								],
							],
							// [
							// 	'width' => 'five wide', 
							// 	'params' => [
							// 		'placeholder' => rl3('Page name'), 
							// 		'origin' => ['name' => 'Extension[settings][system][url_conditions][#url_conditions#][page]']
							// 	],
							// ],
							[
								'width' => 'four wide', 
								'type' => 'select',
								'options' =>  [
									'and' => rl3('if ALL rules match'),
									'or' => rl3('if ANY rules match'),
								],
								'params' => [
									'origin' => ['name' => 'Extension[settings][system][url_conditions][#url_conditions#][logic]']
								],
							],
							[
								'width' => 'two wide', 
								'type' => 'btns',
								'btns' => [
									'add' => [],
									'delete' => [],
								]
							],
						],
						'r2' => [
							[
								'type' => 'require',
								'file' => dirname(__FILE__).DS.'url_conditions_rules_config.php',
								'vars' => [],
							],
						],
					],
				],
			]
		]);
	?>
</div>

<div class="ui segment tab bottom attached" data-tab="behaviors">
	<div class="ui header purple dividing"><?php el3('Select which behaviors should be enabled by default when available'); ?></div>
	<?php
		// $behaviors_list = $this->controller->Behaviors->list();
		// foreach($behaviors_list as $utype => $behaviors){
		// 	usort($behaviors_list[$utype], function ($a, $b) {
		// 		return $a['group'] <=> $b['group'];
		// 	});
		// }
	?>
	<?php /*foreach($behaviors_list as $utype => $behaviors): ?>
		<?php foreach($behaviors as $behavior): ?>
			<?php if(!empty($behavior['hidden'])){continue;} ?>
			<div class="field">
				<div class="ui checkbox toggle">
					<input type="hidden" name="Extension[settings][behaviors][defaults][<?php echo $behavior['name']; ?>]" data-ghost="1" value="">
					<input type="checkbox" <?php if(!empty($behavior['default'])): ?>checked="checked"<?php endif; ?> class="hidden" name="Extension[settings][behaviors][defaults][<?php echo $behavior['name']; ?>]" value="1">
					<label><?php echo \G3\L\Str::camilize($behavior['group']).' - '.$behavior['category'].' - '.$behavior['title']; ?></label>
					<small><?php echo $behavior['desc']; ?></small>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endforeach;*/ ?>
</div>