<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php $this->view(\G3\Globals::ext_path('chronoforms', 'admin').DS.'themes'.DS.'default'.DS.'views'.DS.'designer.php'); ?>
<?php
	$this->view('views.admin.page_menu', [
		'title' => $this->data['Connection']['title'] ?? rl3('New Form'),
		'class' => 'quti bg-cfpcolor',
		'items' => [
			'general' => [
				'color' => 'white',
				'active' => ($this->get('cf_settings.formeditor.home', 'pages') == 'settings' ? 'active' : ''),
				'icon' => 'cog large',
				'title' => '<span class="ui text large">'.rl3('Settings').'</span>',
			],
			'pages' => [
				'color' => 'white',
				'active' => ($this->get('cf_settings.formeditor.home', 'pages') == 'pages' ? 'active' : ''),
				'icon' => 'copy large',
				'title' => '<span class="ui text large">'.rl3('Pages').'</span>',
			],
			'repo' => [
				'color' => 'white '.($this->data('Connection.apptype') != 'connectivity' ? 'hidden' : ''),
				'icon' => 'box large',
				'title' => '<span class="ui text large">'.rl3('Repo').'</span>',
			],
		],
		'btns' => [
			[
				'color' => 'green '.(empty($this->data['Connection']['id']) ? '' : 'hidden'),
				'name' => 'apply',
				'url' => r3('index.php?ext=chronoforms&cont=connections&act=edit&apply=1'),
				'hint' => rl3('Save changes and reload the editor'),
				'icon' => 'check-double',
				'title' => rl3('Create Form'),
				'attrs' => ['data-fn' => 'saveform']
			],
			[
				'color' => 'active inverted '.(!empty($this->data['Connection']['id']) ? '' : 'hidden'),
				'name' => 'apply',
				'url' => r3('index.php?ext=chronoforms&cont=connections&act=edit&apply=1'.(!empty($this->data['Connection']['id']) ? '&tvout=json' : '')),
				'hint' => rl3('Save changes'),
				'icon' => 'check',
				'title' => !empty($this->data['Connection']['id']) ? rl3('Apply') : rl3('Save'),
				'attrs' => [
					'data-apply' => !empty($this->data['Connection']['id']) ? '1' : '0', 
					'data-fn' => !empty($this->data['Connection']['id']) ? 'none' : 'saveform',
				]
			],
			[
				'color' => 'black inverted '.(!empty($this->data('Connection.id')) ?: 'disabled'),
				'href' => r3('index.php?ext=chronoforms&cont=manager&chronoform='.$this->data('Connection.alias', '')),
				'hint' => rl3('Preview form in the admin area'),
				'icon' => 'user-secret',
				'title' => rl3('Admin View'),
				'attrs' => ['target' => '_blank']
			],
			[
				'color' => 'black inverted '.(!empty($this->data('Connection.id')) ?: 'disabled'),
				'href' => r3(\G3\Globals::get('ROOT_URL').'index.php?ext=chronoforms&cont=manager&chronoform='.$this->data('Connection.alias', '')),
				'hint' => rl3('Preview form at frontend'),
				'icon' => 'globe',
				'title' => rl3('Front View'),
				'attrs' => ['target' => '_blank']
			],
			[
				'color' => 'green '.(!empty($this->data['Connection']['id']) ? '' : 'hidden'),
				'name' => 'apply',
				'url' => r3('index.php?ext=chronoforms&cont=connections&act=edit&apply=1'),
				'hint' => rl3('Save changes and reload the editor'),
				'icon' => 'save',
				// 'title' => rl3('Create Form'),
				'attrs' => ['data-fn' => 'saveform']
			],
			[
				'color' => 'active inverted '.(!empty($this->data('Connection.id')) ?: 'disabled'),
				'href' => r3('index.php?ext=chronoforms&cont=connections&act=backup&gcb[]='.$this->data('Connection.id')),
				'hint' => rl3('Download Form backup'),
				'icon' => 'download',
				// 'title' => rl3('Backup'),
			],
			[
				'color' => 'active inverted',
				'href' => 'https://www.youtube.com/playlist?list=PLNdPw6Bog3zcuSKs7NGNi8QPtfj5IsxQA',
				'hint' => rl3('Tutorials'),
				'icon' => 'question',
				// 'title' => rl3('Close'),
				'attrs' => ['target' => '_blank']
			],
			[
				'color' => 'active inverted cheatsheet',
				'href' => '',
				'hint' => rl3('Shortcodes Cheatsheet'),
				'icon' => 'atlas',
				// 'title' => rl3('Close'),
				'attrs' => ['target' => '_blank']
			],
			[
				'color' => 'active inverted',
				'href' => r3('index.php?ext=chronoforms&cont=connections'),
				'hint' => rl3('Close'),
				'icon' => 'times',
				// 'title' => rl3('Close'),
			],
		]
	]);
?>

<div class="ui bottom attached tab segment quti bg-grey200 <?php if($this->get('cf_settings.formeditor.home', 'pages') == 'settings'): ?>active<?php endif; ?>" data-tab="general">
	<?php $this->view(dirname(__FILE__).DS.'settings.php'); ?>
</div>

<div class="ui bottom attached tab segment quti bg-grey200 <?php if($this->get('cf_settings.formeditor.home', 'pages') == 'pages'): ?>active<?php endif; ?>" data-tab="pages" data-name="page">
	<?php $this->view(dirname(__FILE__).DS.'dragndrop_forms.php'); ?>
</div>

<?php if($this->data('Connection.apptype') == 'connectivity'): ?>
<div class="ui bottom attached tab segment quti bg-grey200" data-tab="repo">
	<?php $this->view(dirname(__FILE__).DS.'dragndrop_connectivity.php'); ?>
</div>
<?php endif; ?>

<?php $this->view(dirname(__FILE__).DS.'shortcodes_table.php'); ?>