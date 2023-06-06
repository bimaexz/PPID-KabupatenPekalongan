<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
		'title' => rl3('Translations Manager'),
		'class' => 'quti bg-blue800',
		'btns' => [
			[
				'color' => 'active inverted',
				'href' => r3('index.php?ext='.$this->get('ext_name')),
				'hint' => rl3('Close'),
				'icon' => 'times',
				'title' => rl3('Close'),
			],
		]
	]);

	$files = \G3\L\Folder::getFiles(\G3\Globals::ext_path($this->get('ext_name'), 'admin').'locales'.DS, false, '*.ini');
	$langs = [];
	foreach($files as $file){
		$langs[] = rl3('Local').' - '.str_replace('.ini', '', basename($file));
	}
?>
<div class="ui segment attached">
	<div class="equal width fields">
		<div class="field">
			<label><?php el3('Language tag'); ?></label>
			<select name="lang" class="ui fluid dropdown search" data-allowadditions="1" data-clearable="1">
				<option value=""></option>
				<?php foreach($langs as $lang): ?>
					<option value="file:<?php echo $lang; ?>"><?php echo $lang; ?></option>
				<?php endforeach; ?>
			</select>
			<small><?php el3('Select a language file to modify or enter a language tag to build a new file, example language tags: en_GB or ja_JP'); ?></small>
		</div>
		<div class="field">
			<label>&nbsp;</label>
			<button class="ui button green icon labeled" name="build"><i class="faicon regular:edit"></i><?php el3('Build language file'); ?></button>
		</div>
	</div>
	
</div>

<?php if(!empty($this->data['lang'])): ?>
	<div class="ui segment attached">
		<h2 class="ui header dividing">
			<?php el3('Update and save'); ?>
			<div class="sub header"><?php el3('You can update any of the language strings below then save the updated language file.'); ?></div>
		</h2>
		<div class="field">
			<?php if(isset($this->data['build'])): ?>
			<button class="ui button blue icon labeled right floated" name="update"><i class="faicon save"></i><?php el3('Update language file'); ?></button>
			<?php endif; ?>
			<?php if(isset($this->data['custom'])): ?>
			<!-- <button class="compact ui button purple icon labeled" name="save"><i class="checkmark icon"></i><?php el3('Update custom file'); ?></button> -->
			<?php endif; ?>
		</div>
		<div class="field">
			<label><?php el3('Language strings'); ?></label>
			<textarea name="language_strings" rows="30"></textarea>
		</div>
	</div>
<?php endif; ?>