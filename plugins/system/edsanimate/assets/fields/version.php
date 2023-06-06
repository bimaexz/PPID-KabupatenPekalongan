<?php
defined('_JEXEC') or die;

class JFormFieldEDS_Version extends JFormField
{
	public $type = 'Version';
	private $params = null;
	
	protected function getLabel(){
		return '';		
	}
	
	protected function getInput(){
		
		$this->params = $this->element->attributes();

		$extension = $this->get('extension');
		$xml = $this->get('xml');
		
		if (!$xml && $this->form->getValue('element'))
		{
			if ($this->form->getValue('folder'))
			{
				$xml = 'plugins/' . $this->form->getValue('folder') . '/' . $this->form->getValue('element') . '/' . $this->form->getValue('element') . '.xml';
			}
			else
			{
				return '';
			}
			if (!JFile::exists(JPATH_SITE . '/' . $xml))
			{
				return '';
			}
		}

		if (!strlen($extension) || !strlen($xml))
		{
			return '';
		}

		$authorise = JFactory::getUser()->authorise('core.manage', 'com_installer');
		if (!$authorise)
		{
			return '';
		}
		
		require_once JPATH_PLUGINS . '/system/edsanimate/assets/versions.php';
		
		return EDSVersions::getInstance()->getMessage($extension, $xml);
	}
	
	private function get($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
	
	
}
