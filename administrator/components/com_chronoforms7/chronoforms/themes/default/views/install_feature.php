<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
		'title' => rl3('Install ChronoForms7 Addons'),
		'class' => 'quti bg-cfpcolor',
		'btns' => [
			[
				'color' => 'active inverted',
				'href' => r3('index.php?ext=chronoforms&cont=connections'),
				'hint' => rl3('Close'),
				'icon' => 'times',
				'title' => rl3('Close'),
			],
		]
	]);
?>
<div class="quti segment rounded-b mt-0">

	<div class="field">
		<label><?php el3('Select your addon file'); ?></label>
		<input type="file" name="upload" value="" accept=".zip">
	</div>
	
	
	<button class="compact ui button green icon labeled quti bg-green700 text-green100">
		<i class="faicon check"></i><?php el3('Upload & Install'); ?>
	</button>

	<!-- <a class="compact ui button icon labeled quti bg-blue700 text-green100" href="<?php echo r3('index.php?ext=chronoforms&act=install_feature&url='.base64_encode('')); ?>">
		<i class="faicon download"></i><?php el3('Install Google Lib'); ?>
	</a> -->
</div>