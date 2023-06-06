<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
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
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
	->useScript('form.validate');

HTMLHelper::_('bootstrap.framework');

$template = Factory::getApplication()->getTemplate();
HTMLHelper::_('stylesheet', "administrator/templates/$template/css/template.css");

$app = Factory::getApplication();
$input = $app->input;
$plug_type = $input->get( 'plug_type' );
$plug_name = $input->get( 'plug_name' );

$canDo = ContentHelper::getActions('com_gmapfp');
?>		
			
<form action="<?php echo JRoute::_('index.php?option=com_gmapfp&view=config&layout=edit&tmpl=component&plug_type='.$plug_type.'&plug_name='.$plug_name); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	<div id="subhead" class="subhead mb-3 load-fadein bg-white shadow-sm" >
		<div id="container-collapse" class="container-collapse"></div>
			<div class="row">
				<div class="col-md-12">
					<nav aria-label="Toolbar" tabindex="-1" id="ui-skip-84">
						<div class="btn-toolbar d-flex" role="toolbar" id="toolbar">

							<?php if ($canDo->get('core.admin')) : ?>
							<button class="button-apply  btn btn-sm btn-success" type="submit" onclick="Joomla.submitbutton('config.save');">
							<span class="icon-apply" aria-hidden="true"></span>
							<?php echo Text::_('JTOOLBAR_APPLY'); ?></button>
						
							<button class="button-save  btn btn-sm btn-success" type="submit" onclick="Joomla.submitbutton('config.save');open(location, '_self').close();window.close();">
							<span class="icon-save" aria-hidden="true"></span>
							<?php echo Text::_('JTOOLBAR_SAVE'); ?></button>
							<?php endif; ?>

							<button class="button-cancel  btn btn-sm btn-danger" type="button" onclick="open(location, '_self').close();window.close();">
							<span class="icon-cancel" aria-hidden="true"></span>
							<?php echo Text::_('JTOOLBAR_CLOSE'); ?></button>

					</div>
				</nav>
			</div>
		</div>
	</div>
	<div>
		<div class="row">
			<div class="col-md-12 form-vertical form-no-margin">
				<?php echo $this->form->renderFieldset('basic'); ?>
			</div>
		</div>
	</div>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="plug_type" value="<?php echo $plug_type; ?>" />
	<input type="hidden" name="plug_name" value="<?php echo $plug_name; ?>" />
	<?php echo HTMLHelper::_( 'form.token' ); ?>
</form>
<div class="copyright" align="center">
	<br />
	<?php echo Text::_( 'COM_GMAPFP_COPYRIGHT' );?>
</div>
