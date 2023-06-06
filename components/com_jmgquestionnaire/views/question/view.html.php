<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * JMG Question view.
 * @since  1.5
 */
class JmgQuestionnaireViewQuestion extends JViewLegacy
{
	protected $item;
	protected $steps;
	protected $questions;
	protected $state;
	protected $params;
	protected $form;
	protected $user;
	protected $app;
	
	function display($tpl = null)
	{
		$this->app        	= JFactory::getApplication();
		$this->user 		= JFactory::getUser();
		$this->item 		= $this->get('Item');
		$this->steps		= $this->get('Steps');
		$this->questions	= $this->get('Questions');
		$this->form   		= $this->get('Form');
		$this->state 		= $this->get('State');
		
		$bytes = random_bytes(30);
		$uniqueid = bin2hex($bytes);
		$this->app->input->cookie->set('uniqueid',$uniqueid,1,'/');
		
		// Merge article params. If this is single-article view, menu params override article params
		// Otherwise, article params override menu item params
		// Load the parameters.
		$this->params = $this->app->getParams();
		$active       = $this->app->getMenu()->getActive();
		$temp         = clone $this->params;
		
		$this->_prepareDocument();
		return parent::display($tpl);
	}
	/**
	* Prepares the document.
	* @return  void
	*/
	protected function _prepareDocument()
	{
		if(empty($this->params->get('page_title', ''))){
			$this->document->setTitle(JText::_('COM_JMGQUESTIONNAIREE_QUESTIONNAIRE_TITLE'));
		}
		else{
			$this->document->setTitle($this->params->get('page_title', ''));
		}
		
	}
}