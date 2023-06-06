<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_3F
	* Creation date: Septembre 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Registry\Registry;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('com_contenthistory');
$wa->useScript('jquery')
	->useScript('keepalive')
	->useScript('form.validate')
	->useScript('com_contenthistory.admin-history-versions')
	->useScript('com_gmapfp.admin_manage');

// Create shortcut to parameters.
$params = clone $this->state->get('params');

$app = Factory::getApplication();
$input = $app->input;

$assoc = Associations::isEnabled();
$hasAssoc = ($this->form->getValue('language', null, '*') !== '*');

// In case of modal
$isModal = $input->get('layout') === 'modal';
$layout  = $isModal ? 'modal' : 'edit';
$tmpl    = $isModal || $input->get('tmpl', '', 'cmd') === 'component' ? '&tmpl=component' : '';

//position correctement le sélecteur "link externe" => link/article
if ($this->item->link) $this->form->setValue('select_link_type', null, 1);
if ($this->item->article_id) $this->form->setValue('select_link_type', null, 2);
?>

<form action="<?php echo JRoute::_('index.php?option=com_gmapfp&layout=' . $layout . $tmpl . '&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">

	<?php echo LayoutHelper::render('joomla.edit.title_alias', $this); ?>

	<div>
		<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'general', JText::_('COM_GMAPFP_LOCALISATION')); ?>
		<div class="row">
			<div class="col-md-4">
				<fieldset class="adminform">
					<?php echo $this->form->renderField('adresse'); ?>
					<?php echo $this->form->renderField('adresse2'); ?>
					<?php echo $this->form->renderField('codepostal'); ?>
					<?php echo $this->form->renderField('ville'); ?>
					<?php echo $this->form->renderField('departement'); ?>
					<?php echo $this->form->renderField('pays'); ?>
					<?php echo $this->form->renderField('tel'); ?>
					<?php echo $this->form->renderField('email'); ?>
					<?php echo $this->form->renderField('web'); ?>
			</fieldset>
			</div>
			<div class="col-md-5">
				<fieldset class="form-vertical form-no-margin">
					<?php echo $this->form->renderField('map'); ?>
				</fieldset>
					<fieldset class="form-vertical form-no-margin">
						<?php echo $this->form->renderField('marqueur'); ?>
					</fieldset>
			</div>
			<div class="col-lg-3">
				<div class="card">
					<div class="card-body">
						<?php echo LayoutHelper::render('joomla.edit.global', $this); ?>
					</div>
				</div>
			</div>
		</div>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>

		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'detail', JText::_('COM_GMAPFP_DETAILS')); ?>
		<div class="row">
			<div class="col-md-9 form-vertical form-no-margin">
				<?php echo $this->form->renderFieldset('detail'); ?>
			</div>
			<div class="col-lg-3">
				<div class="card">
					<div class="card-body">
						<fieldset class="form-vertical form-no-margin">
						<?php echo $this->form->renderFieldset('main-img'); ?>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>

		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'externe', JText::_('COM_GMAPFP_VIEW_EXTERNAL_LINK')); ?>
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->form->renderFieldset('externe'); ?>
			</div>
		</div>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>

		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'publishing', Text::_('JGLOBAL_FIELDSET_PUBLISHING')); ?>
		<div class="row">
			<div class="col-md-6">
				<fieldset id="fieldset-publishingdata" class="options-grid-form options-grid-form-full">
					<legend><?php echo Text::_('JGLOBAL_FIELDSET_PUBLISHING'); ?></legend>
					<div>
					<?php echo LayoutHelper::render('joomla.edit.publishingdata', $this); ?>
					</div>
				</fieldset>
			</div>
			<div class="col-md-6">
				<fieldset id="fieldset-metadata" class="options-grid-form options-grid-form-full">
					<legend><?php echo Text::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'); ?></legend>
					<div>
					<?php echo LayoutHelper::render('joomla.edit.metadata', $this); ?>
					</div>
				</fieldset>
			</div>
		</div>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>
		
		<?php if (!$isModal && $assoc) : ?>
			<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'associations', Text::_('JGLOBAL_FIELDSET_ASSOCIATIONS')); ?>
			<?php if ($hasAssoc) : ?>
				<fieldset id="fieldset-associations" class="options-grid-form options-grid-form-full">
				<legend><?php echo Text::_('JGLOBAL_FIELDSET_ASSOCIATIONS'); ?></legend>
				<div>
				<?php echo LayoutHelper::render('joomla.edit.associations', $this); ?>>
				</div>
				</fieldset>
			<?php endif; ?>
			<?php echo HTMLHelper::_('uitab.endTab'); ?>
		<?php elseif ($isModal && $assoc) : ?>
			<div class="hidden"><?php echo LayoutHelper::render('joomla.edit.associations', $this); ?></div>
		<?php endif; ?>

		<?php echo HTMLHelper::_('uitab.endTabSet'); ?>

	</div>

	<input type="hidden" name="task" value="" />
	<?php echo HTMLHelper::_( 'form.token' ); ?>
</form>
<div class="copyright" align="center">
	<br />
	<?php echo Text::_( 'COM_GMAPFP_COPYRIGHT' );?>
</div>
