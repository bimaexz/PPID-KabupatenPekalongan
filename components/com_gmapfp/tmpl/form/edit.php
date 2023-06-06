<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_8F
	* Creation date: Juillet 2022
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
	->useScript('form.validate')
	->useScript('com_gmapfp.form-edit')
	->useScript('com_gmapfp.admin_manage');

$this->tab_name = 'com-gmapfp-form';
$this->ignore_fieldsets = array('image-intro', 'image-full', 'jmetadata', 'item_associations');
$this->useCoreUI = true;

// Create shortcut to parameters.
$params = $this->state->get('params');

// This checks if the editor config options have ever been saved. If they haven't they will fall back to the original settings.
$editoroptions = isset($params->show_publishing_options);

if (!$editoroptions)
{
	$params->show_urls_images_frontend = '0';
}
?>
<div class="edit item-page">
	<?php if ($params->get('show_page_heading')) : ?>
	<div class="page-header">
		<h1>
			<?php echo $this->escape($params->get('page_heading')); ?>
		</h1>
	</div>
	<?php endif; ?>

	<form action="<?php echo Route::_('index.php?option=com_gmapfp&a_id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical">
		<fieldset>
			<?php echo HTMLHelper::_('uitab.startTabSet', $this->tab_name, array('active' => 'location')); ?>

			<?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'location', Text::_('COM_GMAPFP_LOCALISATION')); ?>
				<?php echo $this->form->renderField('title'); ?>

				<?php if (is_null($this->item->id)) : ?>
					<?php echo $this->form->renderField('alias'); ?>
				<?php endif; ?>

				<?php echo $this->form->renderField('adresse'); ?>
				<?php echo $this->form->renderField('adresse2'); ?>
				<?php echo $this->form->renderField('codepostal'); ?>
				<?php echo $this->form->renderField('ville'); ?>
				<?php echo $this->form->renderField('departement'); ?>
				<?php echo $this->form->renderField('pays'); ?>
				<?php echo $this->form->renderField('tel'); ?>
				<?php echo $this->form->renderField('email'); ?>
				<?php echo $this->form->renderField('web'); ?>
					<?php echo $this->form->renderField('map'); ?>
						<?php echo $this->form->renderField('marqueur'); ?>

			<?php echo HTMLHelper::_('uitab.endTab'); ?>

			<?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'detail', Text::_('COM_GMAPFP_DETAIL')); ?>
				<?php echo $this->form->renderFieldset('main-img'); ?>
				<?php echo $this->form->renderFieldset('detail'); ?>
			<?php echo HTMLHelper::_('uitab.endTab'); ?>

			<?php if ($params->get('show_external_link_frontend',1)) : ?>
			<?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'images', Text::_('COM_GMAPFP_EXTERNAL_LINK')); ?>
				<?php echo $this->form->renderFieldset('externe'); ?>
			<?php echo HTMLHelper::_('uitab.endTab'); ?>
			<?php endif; ?>

			<?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'publishing', Text::_('COM_GMAPFP_PUBLISHING')); ?>
				<?php echo $this->form->renderField('state'); ?>
				<?php echo $this->form->renderField('catid'); ?>
				<?php echo $this->form->renderField('note'); ?>
				<?php if ($params->get('save_history', 0)) : ?>
					<?php echo $this->form->renderField('version_note'); ?>
				<?php endif; ?>
				<?php if ($params->get('show_publishing_options', 1) == 1) : ?>
					<?php echo $this->form->renderField('created_by_alias'); ?>
				<?php endif; ?>
				<?php if ($this->item->params->get('access-change')) : ?>
					<?php echo $this->form->renderField('featured'); ?>
					<?php if ($params->get('show_publishing_options', 1) == 1) : ?>
						<?php echo $this->form->renderField('featured_up'); ?>
						<?php echo $this->form->renderField('featured_down'); ?>
						<?php echo $this->form->renderField('publish_up'); ?>
						<?php echo $this->form->renderField('publish_down'); ?>
					<?php endif; ?>
				<?php endif; ?>
				<?php echo $this->form->renderField('access'); ?>
				<?php if (is_null($this->item->id)) : ?>
					<div class="control-group">
						<div class="control-label">
						</div>
						<div class="controls">
							<?php echo Text::_('COM_GMAPFP_ORDERING'); ?>
						</div>
					</div>
				<?php endif; ?>
			<?php echo HTMLHelper::_('uitab.endTab'); ?>

			<?php if (Multilanguage::isEnabled()) : ?>
				<?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'language', Text::_('JFIELD_LANGUAGE_LABEL')); ?>
					<?php echo $this->form->renderField('language'); ?>
				<?php echo HTMLHelper::_('uitab.endTab'); ?>
			<?php else: ?>
				<?php echo $this->form->renderField('language'); ?>
			<?php endif; ?>

			<?php if ($params->get('show_publishing_options', 1) == 1) : ?>
				<?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'metadata', Text::_('COM_GMAPFP_METADATA')); ?>
					<?php echo $this->form->renderField('metadesc'); ?>
					<?php echo $this->form->renderField('metakey'); ?>
				<?php echo HTMLHelper::_('uitab.endTab'); ?>
			<?php endif; ?>

			<?php echo HTMLHelper::_('uitab.endTabSet'); ?>

			<input type="hidden" name="task" value="">
			<input type="hidden" name="return" value="<?php echo $this->return_page; ?>">
			<?php echo HTMLHelper::_('form.token'); ?>
		</fieldset>
		<div class="mb-2">
			<button type="button" class="btn btn-primary" data-submit-task="item.save">
				<span class="fas fa-check" aria-hidden="true"></span>
				<?php echo Text::_('JSAVE'); ?>
			</button>
			<button type="button" class="btn btn-danger" data-submit-task="item.cancel">
				<span class="fas fa-times" aria-hidden="true"></span>
				<?php echo Text::_('JCANCEL'); ?>
			</button>
			<?php if ($params->get('save_history', 0) && $this->item->id) : ?>
				<?php echo $this->form->getInput('contenthistory'); ?>
			<?php endif; ?>
		</div>
	</form>
</div>
