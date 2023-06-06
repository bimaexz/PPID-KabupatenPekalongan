<?php
/**
 * @package    PdfEmbed
 *
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (C) 2010 - 2021 Techjoomla. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\CMSPlugin;

/**
 * Class for Plg_pdf_embed
 *
 * @package  PdfEmbed
 * @since    1.0
 */
class PlgContentPdf_Embed extends CMSPlugin
{
	protected $autoloadLanguage = true;

	private static $loadPdfjs = false;

	private static $loadAdobejs = false;

	private static $linkCount = 0;

	/**
	 * takes the parameter for pdf
	 *
	 * @param   string   $context  The context of the content being passed to the plugin.
	 *
	 * @param   object   $row      The article object.  Note $article->text is also available
	 * @param   object   $params   The article params
	 * @param   integer  $page     The 'page' number
	 *
	 * @return   html for the pdf
	 *
	 * @since   1.0
	 */
	public function onContentPrepare($context, $row, $params, $page = 0)
	{
		$document = Factory::getDocument();
		$document->addStyleSheet(Uri::root(true) . "/plugins/content/pdf_embed/assets/css/style.css");

		$regex  = "#{pdf[\=|\s]?(.+)}#s";
		$regex1 = '/{(pdf=)\s*(.*?)}/i';

		// Find all instances of mambot and put in $matches
		preg_match_all($regex1, $row->text, $matches);

		// Number of mambots
		$count = count($matches[0]);

		for ($i = 0; $i < $count; $i++)
		{
			$r  = str_replace('{pdf=', '', $matches[0][$i]);
			$r  = str_replace('}', '', $r);
			$ex = explode('|', $r);
			$ploc = $ex[0];
			$w   = $ex[1];
			$isWidthInPer = strpos($w, '%');
			$isWidthInPix = strpos($w, 'px');

			// Check if width is in percentage and pixel
			if (!$isWidthInPer && !$isWidthInPix)
			{
				$w = $w . 'px';
			}

			$h = $ex[2];
			$isHeightInPer = strpos($h, '%');
			$isHeightInPix = strpos($h, 'px');

			// Check if width is in percentage and pixel
			if (!$isHeightInPer && !$isHeightInPix)
			{
				$h = $h . 'px';
			}

			if (isset($ex[3]))
			{
				$viewer      = $ex[3];
				$replace   = $this->plg_pdfembed_replacer($ploc, $w, $h, $viewer, $row->id);
				$row->text = str_replace('{pdf=' . $ex[0] . '|' . $ex[1] . '|' . $ex[2] . '|' . $ex[3] . '}', $replace, $row->text);
			}
			else
			{
				$viewer    = $this->params->def('viewer', 'native');
				$replace   = $this->plg_pdfembed_replacer($ploc, $w, $h, $viewer, $row->id);
				$row->text = str_replace('{pdf=' . $ex[0] . '|' . $ex[1] . '|' . $ex[2] . '}', $replace, $row->text);
			}
		}

		return true;
	}

	/**
	 * Gets  the pdf in site article
	 *
	 * @param   string   $ploc       Takes the address of pdf location
	 * @param   integer  $w          Takes width of pdf
	 * @param   integer  $h          Takes height of pdf
	 * @param   string   $viewer     Takes the view user want to use
	 * @param   integer  $articleId  Takes the article Id
	 *
	 * @return  string in the article
	 */
	public function plg_pdfembed_replacer($ploc, $w, $h, $viewer, $articleId)
	{
		$ploc     = trim($ploc);

		switch ($viewer)
		{
			case "google":
				$ploc = urlencode($ploc);

				return '<div class ="">
							<iframe src="https://docs.google.com/gview?url=' . $ploc . '&embedded=true" style="width:' . $w . '; height:' . $h . ';" frameborder="1">
							</iframe>
						</div>';

			case "pdfjs":
				$this->loadPdfjs();
				$ploc 	= urlencode($ploc);
				$pdfUrl = Uri::root(true) . '/plugins/content/pdf_embed/assets/viewer/pdfjs/web/viewer.html?file=' . $ploc;

				return '<div class ="">
							<iframe class="pdfjspreview" src="' . $pdfUrl . '" style="width:' . $w . '; height:' . $h . ';" frameborder="1">
							</iframe>
						</div>';

			case "adobe":
				$randomNumber = rand(1,999);
				$this->loadAdobejs($ploc, $randomNumber);
				return '<div class="adobejs" style="overflow:auto; width:' . $w . ';height: ' . $h . '">
						<div id="adobe-dc-view-' . $randomNumber. '">
						</div>
					</div>';

			case "link":
				$ploc 	   = urlencode($ploc);
				$id        = 'pdfLinkModal_' . $articleId . '_' . self::$linkCount++;

				return '<a href="#" data-toggle="modal" data-target="#' . $id . '">' .
							Text::_("PLG_CONTENT_PDF_EMBED_LINK_TEXT") . '
						</a>
						<!-- Modal -->
						<div class="modal fade" id="' . $id . '" tabindex="' . $id . '" 
						role="dialog" aria-labelledby="' . $id . '" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-body">
						        <div style="text-align: center;">
									<iframe src="https://docs.google.com/gview?url=' . $ploc . '&embedded=true" 
									style="width:500px; height:500px;" frameborder="0"></iframe>
								</div>
						      </div>
						    </div>
						  </div>
						</div>';

			default:

				return '<div class ="embed-container native-embed-container">
						<embed src="' . $ploc . '" style="width:' . $w . '; height:' . $h . ';" frameborder="1"/></div>';
		}
	}

	/**
	 * Load js file for pdfjs viewer
	 *
	 * @return  void
	 */
	private function loadPdfjs()
	{
		if (!self::$loadPdfjs)
		{
			$download = $this->params->def('download', '1');
			$print    = $this->params->def('print', '1');
			$document = Factory::getDocument();
			$document->addScriptDeclaration('const tjPdfJsDownload = "' . $download . '";const tjPdfJsPrint = "' . $print . '";');
			HTMLHelper::_('script', 'media/pdf_embed/js/myviewer.min.js');
			self::$loadPdfjs = true;
		}
	}

	/**
	 * Load js file for Adobe viewer
	 * 
	 * @param   string   $ploc     Pdf location path
	 * @param   string   $randomNumber   Appending random number to div id form making unique div id for loading more than one adobe pdf on same page
	 * 
	 * @return  void
	 * 
	 * since   v2.3.0
	 */
	private function loadAdobejs($ploc, $randomNumber)
	{
		if (!self::$loadAdobejs)
		{
			// Js code taken from https://documentcloud.adobe.com/view-sdk/main.js file
			HTMLHelper::_('script', 'https://documentcloud.adobe.com/view-sdk/main.js');
			self::$loadAdobejs = true;
		}

		$pdfFileName = basename($ploc);

		$clientId     = $this->params->def('clientid', '', 'string');
		$languageMode = $this->params->def('languagemode', 'en-GB', 'string');

		// Linearization configuration
		$enableLinearization = $this->params->def('enableLinearization', '0', 'string');
		$linearizationFlag   = ($enableLinearization == '1') ? true : false;

		// Print and download option for Pdf
		$showPrintPDF    = $this->params->def('print', '1', 'string');
		$showDownloadPDF = $this->params->def('download', '1', 'string');
		$printPdfFlag    = ($showPrintPDF == '1') ? true : false;
		$downloadPdfFlag = ($showDownloadPDF == '1') ? true : false;

		// Different type of PDF embed mode - Full window, Size container, inline
		$embedMode = $this->params->def('embedmode', 'FULL_WINDOW', 'string');

		// This configue applicable only for Full width embed mode
		$showPageControls = false;
		$pageControls     = $this->params->def('pagecontrol', '0', 'string');

		if ($pageControls == '1' && ($embedMode == 'FULL_WINDOW'))
		{
			$showPageControls = true;
		}

		// This configue applicable only for Full width
		$showLeftHandPanel = false;
		$leftPanel         = $this->params->def('leftpanel', '0', 'string');

		if ($leftPanel == '1' && ($embedMode == 'FULL_WINDOW'))
		{
			$showLeftHandPanel = true;
		}

		$embedModeUpdatedValue = ($embedMode == 'FULL_WINDOW') ? '' : $embedMode;

		$document = Factory::getDocument();
		$document->addScriptDeclaration(
			'document.addEventListener("adobe_dc_view_sdk.ready", function(){
				var adobeDCView = new AdobeDC.View({
					clientId: "' . $clientId . '",
					divId: "adobe-dc-view-' . $randomNumber . '",
					locale:"' . $languageMode . '"
				});
				var previewFilePromise = adobeDCView.previewFile({
					content: {location: {url:"' . $ploc . '"}},
					metaData: {fileName: "' . $pdfFileName . '"}
				},
				{
					dockPageControls:true,
					showAnnotationTools: false,
					enableLinearization: ' . json_encode($linearizationFlag) . ',
					embedMode: "' . $embedModeUpdatedValue . '",
					showDownloadPDF: ' . json_encode($downloadPdfFlag) . ',
					showPrintPDF: ' . json_encode($printPdfFlag) . ',
					showPageControls: ' . json_encode($showPageControls) . ',
					showLeftHandPanel: ' . json_encode($showLeftHandPanel) . ',
				});
			});'
		);
	}
}
