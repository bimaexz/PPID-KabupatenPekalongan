<?php
defined('_JEXEC') or die;

class EDSVersions
{
	public static $instance = null;

	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new EDSAnimateVersions;
		}

		return self::$instance;
	}
}

class EDSAnimateVersions
{
	function getMessage($element = '', $xml = '', $version = '', $type = 'system', $admin = 1)
	{
		if (!$element)
		{
			return '';
		}

		$alias = preg_replace('#[^a-z]#', '', strtolower($element));

		if ($xml)
		{
            if(JV == 'j4') {
                $xml = \Joomla\CMS\Installer\Installer::parseXMLInstallFile(JPATH_SITE . '/' . $xml);
            } else {
                $xml = JApplicationHelper::parseXMLInstallFile(JPATH_SITE . '/' . $xml);
            }
            
			if ($xml && isset($xml['version']))
			{
				$version = $xml['version'];
			}
		}
				
		if (!$version)
		{
			return '';
		}
		
		$url = "";
		$script = "";
		
		if (JV=='j2'){
			$url = 'https://www.downloads.eleopard.in/extensions/update.php?j=25&e=' . $alias;
			JHTML::_('behavior.mootools');
			JHtml::script(JURI::root().'plugins/system/edsanimate/assets/edsanimate_vcheck_j2.js');
			$script = "
				window.addEvent( 'domready', function() {
					edsScripts.loadajax(
						'" . $url . "',
						'edsScripts.displayVersion( data, \"" . $alias . "\", \"" . str_replace(array('FREE', 'PRO'), '', $version) . "\" )',
						'edsScripts.displayVersion( \"\" )'
					);
				});
			";
			
		}else if(JV=='j3' || JV =='j4'){
			$url = 'https://www.downloads.eleopard.in/extensions/update.php?j=3&e=' . $alias;
			JHtml::_('jquery.framework');
			JHtml::script(JURI::root().'plugins/system/edsanimate/assets/edsanimate_vcheck_j3.js');
			$script = "
				jQuery(document).ready(function() {
					edsScripts.loadajax(
						'" . $url . "',
						'edsScripts.displayVersion( data, \"" . $alias . "\", \"" . str_replace(array('FREE', 'PRO'), '', $version) . "\" )',
						'edsScripts.displayVersion( \"\" )'
					);
				});
			";
		}
		
		JFactory::getDocument()->addScriptDeclaration($script);
		
		$msg= "";
		
		if(JV=='j2'){
			$msg =  '<div id="eds_version_' . $alias . '" style="display: none;border:3px solid #F0DC7E;background-color:#EFE7B8;color:#CC0000;margin:10px 0;padding: 2px 5px;">'
			. $this->getMessageText($alias, $version)
			. '</div>';
		}
		else if(JV=='j3' || JV=='j4'){
			$msg = '<div class="alert alert-error" style="display:none;" id="eds_version_' . $alias . '">' . $this->getMessageText($alias, $version) . '</div>';
		}
		
		return $msg;
	}

	function getMessageText($alias, $version)
	{
		$url = 'http://www.downloads.eleopard.in/animate-it-download.html';
		$msg = '<strong>'
			. 'A new version is available'
			. ': <a href="' . $url . '" target="_blank">'
			. 'Update to <span id="eds_newversionnumber_' . $alias . '">Hello</span>'
			. '</a></strong><br /><em>'
			. 'Your current version is '. $version
			. ' ('
			. 'This message will only be displayed to Super Administrator.'
			. ')</em>';

		return html_entity_decode($msg, ENT_COMPAT, 'UTF-8');
	}

}
