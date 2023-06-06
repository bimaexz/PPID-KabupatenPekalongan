<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_1F
	* Creation date: Avril 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('com_contenthistory');
$wa->useScript('keepalive')
	->useScript('form.validate');

$app = Factory::getApplication();
$input = $app->input;

// In case of modal
$isModal = $input->get('layout') === 'modal';
$layout  = $isModal ? 'modal' : 'edit';
$tmpl    = $isModal || $input->get('tmpl', '', 'cmd') === 'component' ? '&tmpl=component' : '';
?>

<form action="<?php echo JRoute::_('index.php?option=com_gmapfp&view=personnalisation&layout=' . $layout . $tmpl . '&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="personnalisation-form" class="form-validate">

	<?php 
	echo $this->form->renderField('nom');
	?>

	<div>
		<div class="row">
			<div class="col-md-9">
				<?php
				echo $this->form->renderField('intro_carte');
				echo $this->form->renderField('conclusion_carte');
				echo $this->form->renderField('intro_detail');
				echo $this->form->renderField('conclusion_detail');
				?>
			</div>
			<div class="col-md-3">
				<div class="card card-light">
					<div class="card-body">
						<?php 
							echo JLayoutHelper::render('joomla.edit.global', $this); 
							echo $this->form->renderField('id');
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<input type="hidden" name="task" value="">
	<?php echo JHtml::_('form.token'); ?>
</form>
<div class="copyright" align="center">
	<br />
	<?php echo JText::_( 'COM_GMAPFP_COPYRIGHT' );?>
</div>
