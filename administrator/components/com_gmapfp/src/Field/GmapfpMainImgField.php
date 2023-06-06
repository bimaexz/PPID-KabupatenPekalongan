<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\GMapFP\Administrator\Field;

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Form\FormField;

class GmapfpMainImgField extends FormField
{
	protected $type = 'GmapfpMainImg';

	protected function getInput()
	{
		HTMLHelper::_('stylesheet', 'com_gmapfp/dropfiles.css', ['version' => 'auto', 'relative' => true]);
		HTMLHelper::_('script', 'com_gmapfp/jquery.filedrop.js', ['version' => 'auto', 'relative' => true]);
	
		$Relative_path_GMapFP_Img = 'images/gmapfp';
		$URI_GMapFP_Img = '../images/gmapfp';
		
		$js = ''
			."jQuery(document).ready(function ($){"
			."	var Main_img_Dropzone = new Dropzone(\"div#dropzonefp\", { "
			."		url: 'index.php?option=com_gmapfp&task=dropfiles.upload_image&".Session::getFormToken()."=1',"
			."		paramName: \"GMapFP_main_img_file\","
			."		clickable: \".drop_info\","
			."		parallelUploads: 1,"
			."		filesizeBase: 1000,"
			."		thumbnailWidth: 240,"
			."		thumbnailHeight: 240,"
			."		thumbnailMethod: \"contain\","
			."		dictMaxFilesExceeded: \"".Text::_('COM_GMAPFP_TOO_MANY_FILES')."\"," //You can not upload any more files.
			."		dictFallbackMessage: \"".Text::_('COM_GMAPFP_BROWSER_NOT_SUPPORT_HTML5')."\"," //Your browser does not support drag'n'drop file uploads.
			."		dictInvalidFileType: \"".Text::_('COM_GMAPFP_FILE_TYPE_NOT_ALLOWED')."\"," //You can't upload files of this type.
			."		dictFileTooBig: \"".Text::_('COM_GMAPFP_FILE_TOO_LARGE_AVEC_INFOS')."\"," //File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.
			."	});"
			.""
			."	Main_img_Dropzone.on(\"success\", function(file) {"
			."		jQuery('#jformimg').append(new Option(file.name, file.name, true, true));"
			."		jQuery('#jformimg').trigger('liszt:updated');"
			."		jQuery('.dz-image-preview:first').remove();"
			."	});"
			."	Main_img_Dropzone.on(\"canceled,\", function(file) {"
			."		console.log('canceled');"
			."		console.log(file);"
			."	});"
			
			
			
			."});"	
			."\r\n"
			."function changeDisplayImage(e) {"
			."	var file_name = jQuery('[name=\'".$this->name."\'] option:selected').val();"
			."		if (file_name) {"
			."			jQuery('.dz-image img').attr( 'src', '".$URI_GMapFP_Img."/' + file_name);"
			."			jQuery('.dz-image img').attr( 'alt', file_name);"
			."		} else {"
			."			jQuery('.dz-image img').attr( 'src', '".$URI_GMapFP_Img."/blank/blank.png');"
			."			jQuery('.dz-image img').attr( 'alt', '');"
			."		}"
			."}"
			."\r\n";
			
		Factory::getDocument()->addScriptDeclaration($js);

		$onchange		= 'onchange="changeDisplayImage();"';

		if ((stristr($this->value,'bmp'))||(stristr($this->value,'gif'))||(stristr($this->value,'jpg'))||(stristr($this->value,'jpeg'))||(stristr($this->value,'png'))) {
			$img = '<div class="dz-image"><img data-dz-thumbnail style="max-width:100%;" alt="'.$this->value.'" src="'.$URI_GMapFP_Img.'/'.$this->value.'"/></div>';
		} else {
			$img = '<div class="dz-image"><img data-dz-thumbnail style="max-width:100%;" alt="blank.png" src="'.$URI_GMapFP_Img.'/blank/blank.png"/></div>';
		}

		$html = ''
			.'<div id="dropzonefp">'
			.'	<label class="drop_info" style="cursor:default;">'
			.		Text::_('COM_GMAPFP_DROP_ZONE_IMAGE')
			.'	</label>'
			.'	<div class="dz-preview dz-image-preview">'
			.		$img
			.'	</div>'
			.'</div>'
			.$Relative_path_GMapFP_Img.HTMLHelper::_('list.images', $this->name, $this->value, $onchange, $Relative_path_GMapFP_Img.'/', "bmp|gif|jpg|jpeg|png"  )
			.'';


		return $html;
	}
}
