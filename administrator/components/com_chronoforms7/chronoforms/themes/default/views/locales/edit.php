<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<style>
	.save_link{display:none !important;}
</style>

<?php $this->view(\G3\Globals::ext_path('chronoforms', 'admin').DS.'themes'.DS.'default'.DS.'views'.DS.'designer.php'); ?>

<?php
	$this->view('views.admin.page_menu', [
			'title' => $this->data['Locale']['title'] ?? rl3('New locale'),
			'class' => 'quti bg-cfpcolor',
			'btns' => [
				// [
				// 	'color' => 'inverted active',
				// 	'name' => 'save',
				// 	'url' => r3('index.php?ext=chronoforms&cont=locales&act=edit'),
				// 	'hint' => rl3('Save and go to the Locales Manager'),
				// 	'icon' => 'blue save',
				// 	'title' => rl3('Save & close'),
				// ],
				[
					'color' => 'inverted active',
					'name' => 'apply',
					'url' => r3('index.php?ext=chronoforms&cont=locales&act=edit'),
					'hint' => rl3('Save changes'),
					'icon' => 'check',
					'title' => rl3('Apply'),
				],
				[
					'color' => 'inverted active',
					'href' => r3('index.php?ext=chronoforms&cont=locales'),
					'hint' => rl3('Close'),
					'icon' => 'times',
					'title' => rl3('Close'),
				],
			]
	]);
?>

<div class="ui segment attached">
	<input type="hidden" name="Locale[id]" value="">

	<div class="equal width fields">
		<div class="field">
			<label><?php el3('Title'); ?></label>
			<input type="text" placeholder="<?php el3('Title'); ?>" name="Locale[title]">
			<small><?php el3('The locale title as going to appear in the wizard designer.'); ?></small>
		</div>
		
		<div class="field">
			<label><?php el3('Alias'); ?></label>
			<input type="text" name="Locale[alias]">
			<small><?php el3('The locale unique alias.'); ?></small>
		</div>

		<div class="field">
			<label><?php el3('Enabled'); ?></label>
			<select name="Locale[enabled]" class="ui fluid dropdown" placeholder="">
				<option value="1"><?php el3('Yes'); ?></option>
				<option value=""><?php el3('No'); ?></option>
			</select>
			<small><?php el3('Enable or disable this Locale.'); ?></small>
		</div>
	</div>

	<div class="field">
		<label><?php el3('Description'); ?></label>
		<textarea placeholder="<?php el3('Description'); ?>" name="Locale[desc]" id="conndesc" rows="2"></textarea>
		<small><?php el3('Locale description shown in wizard tooltips.'); ?></small>
	</div>
</div>
<div class="ui segment bottom attached">
	<div class="ui header dividing"><?php el3('Locales List'); ?></div>
	<?php
		$this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
			'groups' => ['locales'],
			'items' => !empty($this->data['Locale']['locales']) ? $this->data['Locale']['locales'] : null,
			'btns' => ['locales' => ['main' => ['text' => rl3('Add New Locale')]]],
			'class' => 'ui message',
			//'visible' => ['locales' => 1],
			'inputs' => [
				'locales' => [
					'main' => [
						'r1' => [
							[
								'width' => 'five wide',
								'params' => [
									'placeholder' => rl3('Language Tag, example: en_GB or ja_JP'), 
									'origin' => ['name' => 'Locale[locales][#locales#][name]']
								],
							],
							[
								'width' => 'two wide', 
								'type' => 'btns',
								'btns' => [
									'delete' => [],
								]
							],
						],
						'r2' => [
							[
								'width' => 'sixteen wide',
								'type' => 'textarea', 
								'desc' => rl3('Multiline list of strings and their translations, e.g: _STRING_=translation, translations can be called in the app using {l:_STRING_}'), 
								'params' => [
									'rows' => 12,
									'data-codeeditor' => '{"mode":"text"}',
									'origin' => ['name' => 'Locale[locales][#locales#][content]']
								],
							],
						],
					],
				],
			]
		]);
	?>
</div>