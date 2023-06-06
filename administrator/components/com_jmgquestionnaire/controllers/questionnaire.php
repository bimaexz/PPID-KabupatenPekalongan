<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;
JLoader::register('JmgQuestionnaireHelper', JPATH_ADMINISTRATOR . '/components/com_jmgquestionnaire/helpers/jmgquestionnaire.php');

class JmgQuestionnaireControllerQuestionnaire extends JControllerForm
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_JMGQUESTIONNAIRE_QUESTIONNAIRE';

	/**
	 * Method override to check if you can add a new record.
	 * @param   array  $data  An array of input data.
	 * @return  boolean
	 * @since   1.6
	 */
	protected function allowAdd($data = array())
	{
		$filter     = $this->input->getInt('filter_category_id');
		$categoryId = ArrayHelper::getValue($data, 'catid', $filter, 'int');
		$allow      = null;

		if ($categoryId)
		{
			// If the category has been passed in the URL check it.
			$allow = JFactory::getUser()->authorise('core.create', $this->option . '.category.' . $categoryId);
		}

		if ($allow !== null)
		{
			return $allow;
		}

		// In the absence of better information, revert to the component permissions.
		return parent::allowAdd($data);
	}

	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		$recordId   = (int) isset($data[$key]) ? $data[$key] : 0;
		$categoryId = 0;

		if ($recordId)
		{
			$categoryId = (int) $this->getModel()->getItem($recordId)->catid;
		}

		if ($categoryId)
		{
			// The category has been set. Check the category permissions.
			return JFactory::getUser()->authorise('core.edit', $this->option . '.category.' . $categoryId);
		}

		// Since there is no asset tracking, revert to the component permissions.
		return parent::allowEdit($data, $key);
	}

	/**
	 * Method to run batch operations.
	 * @param   string  $model  The model
	 * @return  boolean  True on success.
	 * @since   2.5
	 */
	public function batch($model = null)
	{
		$this->checkToken();

		// Set the model
		$model = $this->getModel('JmgQuestionnaire', '', array());

		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_jmgquestionnaire&view=questionnaires' . $this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}
	/**
	 * Insert a new question
	 * @return  boolean
	 * @since   1.5
	 */
	public function questionadd()
	{
		// Check for request forgeries
		$this->checkToken('request');
		$app    = JFactory::getApplication();
		$model  = $this->getModel('Questionnaire', 'JmgQuestionnaireModel');
		
		// Get the user data.
		$data = $app->input->post->get('jform', array(), 'array');
		$data['name'] = $data['qname'];
		unset($data['qname']);
		
		if($data['name'] != ''){
			$model->questionAdd($data);			
		}
		else{
			JFactory::getApplication()->enqueueMessage(JText::_('COM_JMGQUESTIONNAIRE_EMPTY_QUESTION'),'warning');
		}

		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_jmgquestionnaire&view=questionnaire&layout=edit&id='.$data['questionnaireid'].'&tab=questions', false));
		
		return true;
	}
	/**
	 * Edit a question
	 * @return  boolean
	 * @since   1.5
	 */
	public function questionedit()
	{
		// Check for request forgeries
		$this->checkToken('request');
		$app    = JFactory::getApplication();
		
		// Get the user data.
		$data = $app->input->post->get('jform', array(), 'array');		

		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_jmgquestionnaire&view=questionnaire&layout=edit&id='.$data['id'].'&questionid='.$data['questionid'].'&tab=questions', false));
		
		return true;
	}
	/**
	 * Insert a new invitation
	 * @return  boolean
	 * @since   1.5
	 */
	public function invitationadd()
	{
		// Check for request forgeries
		$this->checkToken('request');
		$app    = JFactory::getApplication();
		$model  = $this->getModel('Questionnaire', 'JmgQuestionnaireModel');
		
		// Get the user data.
		$data = $app->input->post->get('jform', array(), 'array');
		
		if($data['email'] != ''){
			if(JmgQuestionnaireHelper::sendInvitation($data['email'],$data['invitationid'],$data['questionnaireid'])){
				$model->invitationAdd($data);
			}			
		}
		else{
			JFactory::getApplication()->enqueueMessage(JText::_('COM_JMGQUESTIONNAIRE_EMPTY_MAIL'),'warning');
		}

		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_jmgquestionnaire&view=questionnaire&layout=edit&id='.$data['questionnaireid'].'&tab=invitations', false));
		
		return true;
	}
	/**
	 * Insert a new answer
	 * @return  boolean
	 * @since   1.5
	 */
	public function answeradd()
	{
		// Check for request forgeries
		$this->checkToken('request');
		$app    = JFactory::getApplication();
		$model  = $this->getModel('Question', 'JmgQuestionnaireModel');
		
		// Get the user data.
		$data = $app->input->post->get('jform', array(), 'array');
		
		if($data['name'] != ''){
			$model->answerAdd($data);			
		}
		else{
			JFactory::getApplication()->enqueueMessage(JText::_('COM_JMGQUESTIONNAIRE_EMPTY_ANSWER'),'warning');
		}
		
		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_jmgquestionnaire&view=questionnaire&layout=edit&id='.$data['id'].'&questionid='.$data['questionid'].'&tab=questions', false));
		
		return true;
	}
	/**
	 * Set correct answer
	 * @return  boolean
	 * @since   1.5
	 */
	public function setcorrectanswer()
	{
		// Check for request forgeries
		$this->checkToken('request');
		$app    = JFactory::getApplication();
		$model  = $this->getModel('Question', 'JmgQuestionnaireModel');
		
		// Get the user data.
		$data = $app->input->post->get('jform', array(), 'array');

		$model->setCorrectAnswer($data);			
		
		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_jmgquestionnaire&view=questionnaire&layout=edit&id='.$data['id'].'&questionid='.$data['questionid'].'&tab=questions', false));
		
		return true;
	}
	/**
	 * Set correct answer
	 * @return  boolean
	 * @since   1.5
	 */
	public function trashquestion()
	{
		// Check for request forgeries
		$this->checkToken('request');
		$app    = JFactory::getApplication();
		$model  = $this->getModel('Question', 'JmgQuestionnaireModel');
		
		// Get the user data.
		$data = $app->input->post->get('jform', array(), 'array');
		
		// Get the questions.
		$questions = $app->input->get('cid', array(), 'array');
		
		//echo '<pre>';
		//print_r($questions);
		//echo '</pre>';
		//exit;

		$model->trashQuestion($questions);			
		
		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_jmgquestionnaire&view=questionnaire&layout=edit&id='.$data['id'].'&tab=questions', false));
		
		return true;
	}
}
