<?php 

/**
  *	Editor Xtended - Animate It!
  * Copyright (C) 2014 eLEOPARD Design Studios Pvt Ltd. All rights reserved

  * This program is free software: you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation, either version 3 of the License, or
  * (at your option) any later version.

  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.

  * You should have received a copy of the GNU General Public License
  * along with this program.  If not, see <http://www.gnu.org/licenses/>.

  * For any other query please contact us at contact[at]eleopard[dot]in
**/
?>

<?php

defined('_JEXEC') or die;

define('JV', (version_compare(JVERSION, '4', '<') ? (version_compare(JVERSION, '3', '<') ? 'j2' : 'j3') : 'j4'));
class PlgButtonEDSAnimate extends JPlugin
{

	protected $autoloadLanguage = true;

	public function onDisplay($name)
	{
		$sParams = $this->getPluginParameter('system', 'edsanimate');
		$onScrollOffset = $sParams->get('scroll_offset', '75');
		
		$doc = JFactory::getDocument();
		
		$button = new JObject;		

        $js = "";
        if(JV == 'j4') {
            $js = "
			function insertEdsAnimateTag(editor, content)
			{
                if (window.parent.Joomla && window.parent.Joomla.editors && window.parent.Joomla.editors.instances && window.parent.Joomla.editors.instances.hasOwnProperty(editor))
                {
                    window.parent.Joomla.editors.instances[editor].replaceSelection(content);
                }
                else
                {
                    window.parent.jInsertEditorText(content, editor);
                }						
			}  			
			";
        } else {
            $js = "
			function insertEdsAnimateTag(editor, content)
			{
					jInsertEditorText(
					content,
					editor);			
			}  			
			";
        }

		$doc->addScriptDeclaration($js);
		
        if(JV != 'j4') {
		    JHtml::_('behavior.modal');		
        }
	
		if (JFactory::getApplication()->isClient('site')) {
			$link = 'plugins/editors-xtd/edsanimate/popup.php?ih_name='.$name.'&sys_so='.$onScrollOffset;			
		} else {
			$link = '../plugins/editors-xtd/edsanimate/popup.php?ih_name='.$name.'&sys_so='.$onScrollOffset;			
		}
			
			
		$button->modal = true;
		$button->class = 'btn';
		$button->link = $link;
		$button->text = JText::_('Animate It!');
		$button->name = 'wand';
		$button->options = "{handler: 'iframe', size: {x:window.getSize().x-100, y: window.getSize().y-100}}";
        $button->icon    = 'wand';
        $button->iconSVG = '<svg class="eds-animateit-icon" style="width: 1em; height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M894.8 259.8c0 8.6-2.9 15.7-8.6 21.4L274.7 892.6c-5.7 5.7-12.8 8.6-21.4 8.6s-15.7-2.9-21.4-8.6l-94.1-94.1c-5.7-5.7-8.6-12.8-8.6-21.4s2.9-15.7 8.6-21.4l611.5-611.5c5.7-5.7 12.8-8.6 21.4-8.6 8.6 0 15.7 2.9 21.4 8.6l94.1 94.1c5.7 5.8 8.6 12.9 8.6 21.5z m-642.4-90.4l46.6 14.3-46.6 14.3-14.3 46.6-14.3-46.6-46.6-14.3 46.6-14.3 14.3-46.6 14.3 46.6z m166.4 77l93.2 28.5-93.2 28.5-28.5 93.2-28.5-93.2-93.2-28.5 93.2-28.5 28.5-93.2 28.5 93.2z m137.9-77l46.6 14.3-46.6 14.3-14.3 46.6-14.3-46.6-46.6-14.3 46.6-14.3 14.3-46.6 14.3 46.6z m125.5 229.7l139.3-139.3-50.9-50.9-139.3 139.3 50.9 50.9zM861 473.7l46.6 14.3-46.6 14.2-14.3 46.6-14.3-46.6-46.6-14.3 46.6-14.3 14.3-46.6 14.3 46.7z"  /></svg>';
		return $button;

	}
	
	private function getPluginParameter($type , $name){
		$plugin = JPluginHelper::getPlugin($type, $name);
		$params = null;
		if(isset($plugin) && isset($plugin->params)){
			$params = $plugin->params;
		}
		return (new JRegistry($params));
	}
	
}
