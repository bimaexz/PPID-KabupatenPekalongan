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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('jquery')
	->useScript('keepalive')
	->useScript('form.validate')
	->useScript('com_gmapfp.admin-marqueur-edit');

$app = Factory::getApplication();
$input = $app->input;

$this->useCoreUI = true;

// In case of modal
$isModal = $input->get('layout') === 'modal';
$layout  = $isModal ? 'modal' : 'edit';
$tmpl    = $isModal || $input->get('tmpl', '', 'cmd') === 'component' ? '&tmpl=component' : '';
?>

<form action="<?php echo Route::_('index.php?option=com_gmapfp&layout=' . $layout . $tmpl . '&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="marqueur-form" class="form-validate">
	<?php echo $this->form->renderField('nom');?>
	
		<div class="row">
			<div class="col-lg-9">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<?php echo $this->form->renderField('alias');?>
								<?php echo $this->form->renderField('url_type');?>
								<?php echo $this->form->renderField('url_externe');?>
								<?php echo $this->form->renderField('url_interne');?>
								<?php echo $this->form->renderField('url');?>
								<?php echo $this->form->renderField('note10');?>
								<div class="row">
									<div class="col-md-6">
										<?php echo $this->form->renderField('marker_width');?>
									</div>
									<div class="col-md-6">
										<?php echo $this->form->renderField('marker_height');?>
									</div>
								</div>
								<?php echo $this->form->renderField('note11');?>
								<div class="row">
									<div class="col-md-6">
										<?php echo $this->form->renderField('centre_x');?>
									</div>
									<div class="col-md-6">
										<?php echo $this->form->renderField('centre_y');?>
									</div>
								</div>
								<?php echo $this->form->renderField('url_shadow');?>
								<?php echo $this->form->renderField('shadow_width');?>
								<?php echo $this->form->renderField('shadow_height');?>
								<?php echo $this->form->renderField('optimized');?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<fieldset class="form-vertical">
					<div class="control-group" style="min-height: 120px;">
						<div class="control-label">
							<label id="jform_url-lbl" for="jform_preview">
								<?php echo Text::_( 'COM_GMAPFP_POSITION_MARKER_PREVIEW' ); ?>
							</label>
						</div>
						<div class="controls">
							<div style="position: absolute; top: 29px; left: 59px; width: 32px; height: 32px;">
								<img src="../media/com_gmapfp/images/cible.png"/>
							</div>
							<div id="pos_centre_ombre" style="z-index : 999; position: absolute; top: <?php echo (44-$this->item->centre_y); ?>px; left: <?php echo (75-$this->item->centre_x); ?>px;">
								<img id="image_ombre" src="<?php echo $this->item->url_shadow; ?>"/>
							</div>
							<div id="pos_centre_img" style="z-index : 999; position: absolute; top: <?php echo (44-$this->item->centre_y); ?>px; left: <?php echo (75-$this->item->centre_x); ?>px;">
								<img id="image_marqueur" src="../<?php echo $this->item->url; ?>"/>
							</div>
						</div>
					</div>
				</fieldset>
				<?php echo LayoutHelper::render('joomla.edit.global', $this); ?>
			</div>
		</div>
	</div>
	
	<input type="hidden" name="task" value="">
	<?php echo HTMLHelper::_('form.token'); ?>
</form>
<div class="copyright" align="center">
	<br />
	<?php echo Text::_( 'COM_GMAPFP_COPYRIGHT' );?>
</div>
