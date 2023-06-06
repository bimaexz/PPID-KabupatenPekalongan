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
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('jquery')
	->useScript('com_gmapfp.admin_accueil');
	
Text::script('COM_GMAPFP_ERROR_UPDATE_NEWS');

$lang		= Factory::getLanguage();

$langue		=substr((@$lang->getTag()),0,2);
if ($langue!='fr') $langue = 'en';

$user	= Factory::getUser();
?>
<h1>GMapFP</h1>
<section id="content" class="content">
	<div class="row">
		<div class="col-md-6">
			<nav class="quick-icons" aria-label="Quick Links System" tabindex="-1">
				<ul class="nav flex-wrap">
					<li class="quickicon quickicon-single col mb-3">
						<a href="index.php?option=com_config&view=component&component=com_gmapfp&path=&return=<?php echo base64_encode(JURI::root()."administrator/index.php?option=com_gmapfp") ?>">
							<div class="quickicon-icon d-flex align-items-end big">
								<div class="fas fa-cog" aria-hidden="true"></div>
							</div>
							<div class="quickicon-name d-flex align-items-end">
								<?php echo JText::_('JFIELD_PARAMS_LABEL'); ?>				
							</div>
						</a>
					</li>
					<li class="quickicon quickicon-single col mb-3">
						<a class="success" href="index.php?option=com_gmapfp&view=items">
							<div class="quickicon-icon d-flex align-items-end big">
								<div class="fas fa-map-marked-alt" aria-hidden="true"></div>
							</div>
							<div class="quickicon-name d-flex align-items-end">
								<?php echo JText::_('COM_GMAPFP_LIEUX'); ?>				
							</div>
						</a>
					</li>
					<li class="quickicon quickicon-single col mb-3">
						<a href="index.php?option=com_gmapfp&view=marqueurs">
							<div class="quickicon-icon d-flex align-items-end big">
								<div class="fas fa-map-marker-alt" aria-hidden="true"></div>
							</div>
							<div class="quickicon-name d-flex align-items-end">
								<?php echo JText::_('COM_GMAPFP_MARQUEURS'); ?>				
							</div>
						</a>
					</li>
					<li class="quickicon quickicon-single col mb-3">
						<a href="index.php?option=com_categories&view=categories&extension=com_gmapfp">
							<div class="quickicon-icon d-flex align-items-end big">
								<div class="fas fa-folder-open" aria-hidden="true"></div>
							</div>
							<div class="quickicon-name d-flex align-items-end">
								<?php echo JText::_('JCATEGORIES'); ?>				
							</div>
						</a>
					</li>
					<li class="quickicon quickicon-single col mb-3">
						<a href="index.php?option=com_gmapfp&view=personnalisations">
							<div class="quickicon-icon d-flex align-items-end big">
								<div class="fas fa-file-alt" aria-hidden="true"></div>
							</div>
							<div class="quickicon-name d-flex align-items-end">
								<?php echo JText::_('COM_GMAPFP_PERSONNALISATION'); ?>				
							</div>
						</a>
					</li>
					<li class="quickicon quickicon-single col mb-3">
						<a href="index.php?option=com_gmapfp&view=css">
							<div class="quickicon-icon d-flex align-items-end big">
								<div class="fas fa-file-signature" aria-hidden="true"></div>
							</div>
							<div class="quickicon-name d-flex align-items-end">
								CSS				
							</div>
						</a>
					</li>
			
				</ul>
			</nav>
			<p></p>
			<div  style="clear:both;" class="row">
				<div class="icon mb-2"  style="width: 108px;">
					<div id="fb-root"></div>
					<script>(function(d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id)) return;
						js = d.createElement(s); js.id = id;
						js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.0";
						fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));</script>                        
					<div class="fb-like" data-href="http://www.facebook.com/gmapfp" data-layout="box_count" data-action="like" data-show-faces="true" data-share="true"></div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
		<?php
			echo JHtml::_('bootstrap.startAccordion', 'InfoMenuSlider', array('active' => 'slide0'));
			$tabs	= $this->get('publishedTabs');
			$i = 0;

			if ($tabs)
			foreach ($tabs as $tab) {
				$title = JText::_($tab->title);
				echo JHtml::_('bootstrap.addSlide', 'InfoMenuSlider', \JText::_($tab->title), 'slide' . $i++);
				$contenu = 'infos_' .$tab->name;
				echo $this->$contenu();
				echo JHtml::_('bootstrap.endSlide');
			}

			echo JHtml::_('bootstrap.endAccordion');
		 ?>
		</div>
	</div>
	<table class="admintable">
		<tr>
			<td class="key">
				<?php echo JText::_( 'Forum' );?>
			</td>
			<td>
				<a href="http://www.gmapfp.org/<?php echo $langue; ?>/forum" target="_new">www.gmapfp.org/<?php echo $langue; ?>/forum</a>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'COM_GMAPFP_DOCUMENTATION' );?>
			</td>
			<td>
				<a href="http://www.gmapfp.org/<?php if ($langue=="fr") {echo "fr/telechargement/2---Documentation";} else {echo "en/download/2---Documentation/";}; ?>/documentation" target="_new">www.gmapfp.org/<?php if ($langue=="fr") {echo "fr/telechargement/2---Documentation";} else {echo "en/download/2---Documentation/";}; ?></a>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo '<h1 style="color:red;">'.JText::_( 'COM_GMAPFP_DISCOVER_PRO_VERSION' ).' : '.'</h1>'; ?>
			</td>
			<td>
				<a href="http://pro.gmapfp.org/<?php echo $langue; ?>" target="_new"><?php echo '<h1 style="color:red; text-decoration: underline;">'.JText::_( 'GMapFP Pro' ).'</h1>'; ?></a>
			</td>
		</tr>
	</table>
	<div class="donation">
	<?php 
		echo $this->infos_donation();
	?>
	</div>
</section>
<div class="copyright" align="center">
	<br />
	<?php echo Text::_( 'COM_GMAPFP_COPYRIGHT' );?>
</div>
<div class="clr"></div>

