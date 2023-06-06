<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
		'title' => rl3('Restore Forms'),
		'class' => 'quti bg-cfpcolor',
		
		'btns' => [
			[
				'color' => 'active inverted',
				'href' => r3('index.php?ext=chronoforms&cont=connections'),
				'hint' => rl3('Back to Forms Manager'),
				'icon' => 'arrow-left',
				'title' => rl3('Forms Manager'),
			],
		]
	]);
?>
<div class="ui bottom attached segment">
	
	<div class="field">
		<label><?php el3('ChronoForms Backup File'); ?></label>
		<input type="file" name="backup" accept=".cf7bak,.cf5bak">
		<small><?php el3('Select your ChronoForms7 backup file'); ?></small>
	</div>
	<div class="field">
		<button class="compact ui button green icon labeled" name="restore"><i class="faicon check"></i><?php el3('Upload & Restore'); ?></button>
	</div>
	
</div>