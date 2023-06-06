<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php \GApp3::document()->addCssCode('
	
'); ?>
<?php
	$this->set('quti.colors.cfpcolor', '2B6CB0');

	$this->view('views.admin.extension_menu', [
			'title' => 'ChronoForms7', 
			'vmsg' => 'Forms will display a credits link and a maximum of 15 fields per form on FRONTEND.',
			'items' => [
				['cont' => 'connections', 'title' => rl3('Forms'), 'icon' => 'edit'],
				// ['cont' => 'locales', 'title' => rl3('Locales'), 'icon' => 'language'],
				['cont' => 'acls', 'title' => rl3('ACL'), 'icon' => 'user shield'],
				['cont' => 'service_accounts', 'title' => rl3('Services'), 'icon' => 'key'],
				// ['cont' => 'tags', 'title' => rl3('Tags'), 'icon' => 'tag'],
				['cont' => 'tasks', 'act' => 'settings', 'title' => rl3('Settings'), 'icon' => 'cog'],
				['act' => 'install_feature', 'title' => rl3('Extend'), 'icon' => 'boxes'],
				//['act' => 'install_feature', 'title' => rl3('Install feature'), 'hidden' => true],
				// ['act' => 'info', 'title' => rl3('Shortcodes')],
			]
	]);
?>
<?php if(!\GApp3::extension($this->get('ext'))->valid()): ?>
<div class="quti bg-orange200 p-3 mb-2 border-1 border-red300 border-l-5 rounded font-bold">
	ChronoForms7 is not validated, forms will display a credits line, emails will have a credits link, features marked with red icons <i class="faicon boxes quti text-red"></i> will not work on frontend!
</div>
<?php endif; ?>

<form action="<?php echo \G3\L\Url::current();//r3('index.php?ext='.\GApp3::instance()->extension.'&cont='.\GApp3::instance()->controller.'&act='.\GApp3::instance()->action); ?>" method="post" name="admin_form" id="admin_form" enctype="multipart/form-data" class="ui form">
	{VIEW}
</form>