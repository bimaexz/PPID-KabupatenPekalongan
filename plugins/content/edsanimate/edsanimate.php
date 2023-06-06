<?php

/**
 *	Content - Animate It!
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
// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport( 'joomla.plugin.helper' );

if (!class_exists('EDS_Mobile_Detect')):
include_once JPATH_PLUGINS.'/system/edsanimate/assets/Mobile_Detect.php';
endif;

class plgContentEDSAnimate extends JPlugin {


	protected $autoloadLanguage = true;

	private $enable = true;

	private $globalOffset = 0;

	public function onContentPrepare($context, $article, $params, $limitstart)
	{
		if (!JFactory::getApplication()->isClient('site'))
		{
			return;
		}


		$sParams = $this->getPluginParameter('system', 'edsanimate');
		$enableSmartPhone = $sParams->get('enable_on_phone','1');
		$enableTablet = $sParams->get('enable_on_tab','1');

		$deviceType = $this->detectDevice();
		//$deviceType = 'tablet';//$this->detectDevice();

		$this->enable= ($deviceType=='phone' && intval($enableSmartPhone))
		|| ($deviceType =='tablet' && intval($enableTablet))
		|| ($deviceType =='computer');

		//$oldtext = $article->text. ' #############' . $deviceType;
		$oldtext = $article->text;

		if(($article->text= $this->translateTags($oldtext))===FALSE) {
			$article->text = $oldtext;
		}
		
		$oldtext = $article->text;
		
		if(($article->text = $this->translateNewTags($oldtext))===FALSE) {
			$article->text = $oldtext;
		}
		
	}


	private function translateTags($text)
	{
		try{
				
			$openNeedleStart = '{edsanimate';
			$openNeedleEnd = '}';
			$closeNeedle = '{/edsanimate}';
			$endDiv = '</div>';
			$totalOpenTags = 0;
				
			if(!$this->enable)
			$endDiv = '';
				
			while(($this->globalOffset=strpos($text, $openNeedleStart, $this->globalOffset)) !==FALSE)
			{
				$totalOpenTags++;
				$openTagStart= $this->globalOffset;

				if(($this->globalOffset=  strpos($text, $openNeedleEnd, $this->globalOffset+1))===FALSE)
				return FALSE;
					

				$openTagEnd = $this->globalOffset;

				if(($text = $this->insertOpenDivTag($text,
				$openTagStart,
				$openTagEnd))===FALSE)
				return FALSE;
					
			}


			if($totalOpenTags == 0 || substr_count($text, $closeNeedle) != $totalOpenTags)
			return false;

			$text = str_replace($closeNeedle, $endDiv, $text);

			return $text;
		}
		catch(Exception $e)
		{
			return false;
		}
			
	}

	private function insertOpenDivTag($text, $openTagStart, $openTagEnd)
	{

		try{
				
			$startDiv  = '<div class="';
			
			$scrollOffset = "";

			$startTag = substr($text, $openTagStart+1, $openTagEnd-$openTagStart-1);

			$styleClasses = explode('_', $startTag);
			 
			$styleClasses[0]="";
			
			$scrollOffsetKey = array_search("scrolloffset",$styleClasses);
			
			if($scrollOffsetKey != FALSE)
			{
				$scrollOffset = " eds_scroll_offset=\"". $styleClasses[$scrollOffsetKey + 1] ."\"";
				$styleClasses[$scrollOffsetKey]="";
				$styleClasses[$scrollOffsetKey + 1]="";				
			}
			
				
			$startDiv .= implode(" ", $styleClasses) . '" '.$scrollOffset.'>';
			
			if(!$this->enable)
				$startDiv = '';
	
			$text = substr_replace($text, $startDiv, $openTagStart, $openTagEnd-$openTagStart+1);
			 
			$this->globalOffset = $openTagStart+ strlen($startDiv);
	
			return $text;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	private function translateNewTags($text)
	{
		try{
	
			$openNeedleStart = '{edsnewanimate';
			$openNeedleEnd = '}';
			$closeNeedle = '{/edsnewanimate}';
			$endDiv = '</div>';
			$totalOpenTags = 0;
			
			$this->globalOffset = 0;
	
			if(!$this->enable)
				$endDiv = '';
	
				while(($this->globalOffset=strpos($text, $openNeedleStart, $this->globalOffset)) !==FALSE)
				{
					$totalOpenTags++;
					$openTagStart= $this->globalOffset;
	
					if(($this->globalOffset=  strpos($text, $openNeedleEnd, $this->globalOffset+1))===FALSE)
						return FALSE;
							
	
						$openTagEnd = $this->globalOffset;
	
						if(($text = $this->insertNewOpenDivTag($text,
								$openTagStart,
								$openTagEnd))===FALSE)
							return FALSE;
								
				}
	
	
				if($totalOpenTags == 0 || substr_count($text, $closeNeedle) != $totalOpenTags)
					return false;
	
					$text = str_replace($closeNeedle, $endDiv, $text);
	
					return $text;
		}
		catch(Exception $e)
		{
			return false;
		}
			
	}
	
	private function insertNewOpenDivTag($text, $openTagStart, $openTagEnd)
	{
	
		try{
	
			$startDiv  = '<div ';
				
			$scrollOffset = "";
	
			$startTag = substr($text, $openTagStart+1, $openTagEnd-$openTagStart-1);
	
			$attributes = explode('|', $startTag);
	
			$attributes[0]="";	
			
			$startDiv .= implode(" ", $attributes) . '>';
				
			if(!$this->enable) {				
				$startDiv = '';	
			}
	
			$text = substr_replace($text, $startDiv, $openTagStart, $openTagEnd-$openTagStart+1);

			$this->globalOffset = $openTagStart+ strlen($startDiv);

			return $text;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	private function detectDevice()
	{
	 	static $deviceType = null;
	 	if(!$deviceType)
	 	{
			$detect = new EDS_Mobile_Detect;
			$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
	 	}
	 	return $deviceType;
		
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
?>