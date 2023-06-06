<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<!-- <div class="field">
	<label><?php el3('Active Locales'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][locales][]" class="ui fluid multiple search selection dropdown" data-clearable="1" multiple="multiple" data-keepnonexistent="1">
		<?php //foreach($this->controller->Locales->list() as $locale): ?>
			<option value="<?php echo $locale['Locale']['alias']; ?>"><?php echo $locale['Locale']['title']; ?></option>
		<?php //endforeach; ?>
	</select>
	<small><?php el3('Select which Locales dictionaries you want to use for this form.'); ?></small>
</div> -->

<div class="field">
	<label><?php el3('Custom Locales'); ?></label>
	<small><?php el3('Define locales dictionaries for this form only'); ?></small>
	<?php
		$this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
			'groups' => ['plocales'],
			'items' => $this->data('Connection.'.$utype.'.'.$n.'.plocales', []) ?? [],
			'btns' => ['plocales' => ['main' => ['text' => rl3('Add New Locale Dictionary')]]],
			'class' => 'ui message',
			//'visible' => ['plocales' => 1],
			'inputs' => [
				'plocales' => [
					'main' => [
						'r1' => [
							[
								'width' => 'five wide',
								'params' => [
									'placeholder' => rl3('Language Tag, example: en_GB or ja_JP'), 
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][plocales][#plocales#][name]']
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
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][plocales][#plocales#][content]']
								],
							],
						],
					],
				],
			]
		]);
	?>
</div>