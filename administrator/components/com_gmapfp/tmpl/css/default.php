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
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Editor\Editor;

$editor = Editor::getInstance('codemirror');
$css_path = '../media/com_gmapfp/css/gmapfp.css';

if ($fp = @fopen($css_path, 'r')) {
	$csscontent = @fread($fp, @filesize($css_path));
	$csscontent = htmlspecialchars($csscontent);
} else {
	echo 'Error reading template file: '.$css_path;
}
?>
<div class="row">
	<div id="j-main-container" class="col-md-12">
		<form action="index.php" method="post" name="adminForm" id="adminForm">
				<div class="general">
					<legend><?php echo Text::_( 'Details' ); ?></legend>
					<p><?php echo Text::_( 'COM_GMAPFP_CSS_DETAIL' ); ?></p>
					<div class="intro">
						<?php echo $css_path; ?>
						<span class="componentheading">
						<?php
						echo is_writable($css_path) ? ' - <strong style="color:green;">'.Text::_( 'COM_GMAPFP_CSS_WRITABLE' ).'</strong>' :'<strong style="color:red;">'.Text::_( 'COM_GMAPFP_CSS_NOT_WRITABLE' ).'</strong>';?>
						</span>
					</div>
					<fieldset class="adminform">
						<?php
						echo $editor->display( 'csscontent', $csscontent, '100%', '400', '80', '20', false, 'csscontent');
						?>
					</fieldset>
				</div>
			<input type="hidden" name="option" value="com_gmapfp" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="controller" value="css" />
			<?php echo HTMLHelper::_( 'form.token' ); ?>
		</form>
		<div class="copyright" align="center">
			<br />
			<?php echo Text::_( 'COM_GMAPFP_COPYRIGHT' );?>
		</div>
	</div>
</div>