<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

/**
 * question Model
 *
 * @since  1.5
 */
class JmgQuestionnaireModelQuestion extends JModelItem
{
	/**
	 * Model context string.
	 * @var		string
	 * @since   1.6
	 */
	protected $item;

	/**
	 * Method to auto-populate the model state.
	 * Note. Calling getState in this method will result in recursion.
	 * @return  void
	 * @since   1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('site');

		// Load state from the request.
		$id = $app->input->getInt('id');
		$this->setState('questionnaire.id', $id);
		
		// Load state from the request.
		$step = ($app->input->getInt('step') === null)? 0 : $app->input->getInt('step');
		$this->setState('questionnaire.step', $step);
		
		// Load state from the request.
		$uniqueid = $app->input->getString('uniqueid');
		$this->setState('questionnaire.uniqueid', $uniqueid);
		
		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);
	}
	
	/**
	 * Method to get uniqueid.
	 * @param   integer  $pk  The id of the event.
	 * @return  mixed  Menu item data object on success, false on failure.
	 * @since   1.6
	 
	public function getUniqueid()
	{
		$app = JFactory::getApplication();
		$session = JFactory::getSession();
		$bytes = random_bytes(30);	
		if($session->get('uniqueid') === null){
			$session->set('uniqueid', bin2hex($bytes));
		}
		return $session->get('uniqueid');
	}
	*/
	
	/**
	 * Method to get questionnaire data.
	 * @param   integer  $pk  The id of the questionnaire.
	 * @return  mixed  Menu item data object on success, false on failure.
	 * @since   1.6
	 */
	public function getItem($pk = null)
	{
		$id = $this->getState('questionnaire.id');
		
		if (!isset($this->item)){
		
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
				'a.id AS id,'
				. 'a.name AS name,'
				. 'a.access AS access,'
				. 'a.description AS description,'
				. 'a.annotation AS annotation,'
				. 'a.default_fields AS default_fields,'
				. 'a.template AS template,'
				. 'a.numbering AS numbering,'
				. 'a.style AS style,'
				. 'a.nrbgcolor AS nrbgcolor,'
				. 'a.nrtextcolor AS nrtextcolor,'
				. 'a.color AS color,'
				. 'a.showtitle AS showtitle,'
				. 'a.anonymous AS anonymous,'
				. 'a.invitation AS invitation'
		)
		->from('#__jmgquestionnaire_questionnaires AS a')
		->where('a.state = 1')
		->where('a.id ='. (int) $id);


		$db->setQuery($query);

		$data = $db->loadObject();

		if (empty($data))
		{
			JFactory::getApplication()->enqueueMessage(JText::_('COM_JMGQUESTIONNAIRE_ERROR_QUESTIONNAIRE_NOT_FOUND'),'error');
		}
		}
		$this->item = $data;
		return $this->item;
	}
	
	/**
	* method to get steps.
	*/
	public function &getSteps()
	{
		$id = $this->getState('questionnaire.id');
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id AS id'
			)
		);
		
		$query->from($db->quoteName('#__jmgquestionnaire_questions', 'a'));
		$query->where('a.state = 1');
		$query->where('a.level = 1');
		$query->where('a.questionnaireid ='. (int) $id);
		$query->order($db->quoteName('a.lft') . ' ASC');
		$db->setQuery($query);

		$data = $db->loadObjectList();

		if (empty($data))
		{
			
		}

		$this->steps = $data;
		return $this->steps;
	}
	
	
	/**
	* method to get a list of questions.
	*/
	public function &getQuestions()
	{
		$questions = array();
		$questionnaireid = $this->getState('questionnaire.id');
		$step = $this->getState('questionnaire.step');
		$steps = $this->steps;
		if (array_key_exists($step, $steps)) {
			 // Do stuff because `banana` exists

			$db = $this->getDbo();
			$query = $db->getQuery(true);

			// Select the required fields from the table.
			$query->select(
				$this->getState(
					'list.select',
					'a.id AS id,'
					. 'a.name AS name,'
					. 'a.image AS image,'
					. 'a.imagepos AS imagepos,'
					. 'a.questioningid AS questioningid,'
					. 'a.showon AS showon,'
					. 'a.explanation AS explanation,'
					. 'a.parent_id AS parent_id,'
					. 'a.level AS level'
				)
			);

			$query->from($db->quoteName('#__jmgquestionnaire_questions', 'a'));
			$query->where('a.state = 1');
			$query->where('a.questionnaireid ='. (int) $questionnaireid);
			$query->where('a.id ='. (int) $steps[$step]->id);
			$extend = array('a.state = 1','a.questionnaireid ='. (int) $questionnaireid,'a.parent_id ='. (int) $steps[$step]->id);
			$query->extendWhere('OR', $extend);
			$query->order($db->quoteName('a.lft') . ' ASC');
			$db->setQuery($query);

			$questions = $db->loadObjectList();

			if (empty($data))
			{

			}
		}
		return $questions;
	}
		
	/**
	 * Clicks the URL, incrementing the counter
	 * @return  void
	 * @since   1.5
	 */
	public function getClicks()
	{

			$id = $this->getState('questionnaire.id');
			// Update click count
			$db = $this->getDbo();
			$query = $db->getQuery(true)
				->update('#__jmgquestionnaire_questionnaires')
				->set('clicks = (clicks + 1)')
				->where('id = ' . (int) $id);
			$db->setQuery($query);

		try
			{
				$db->execute();
			}
			catch (RuntimeException $e)
			{
				
			}
		
	}
	
	/**
	 * Collect questionnaire data in session.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public function collectData($step)
	{
		$app = JFactory::getApplication();
		$formdata = $app->input->post->get('jform', array(), 'array');
		$questionnairedata = (json_decode(json_encode($formdata['questionnaire']), FALSE));
		
		$session = JFactory::getSession();
		$bytes = random_bytes(30);	
		if($session->get('questionnairedatas') === null){
			$steps = array();
			$steps[$step] = $questionnairedata;
			$session->set('questionnairedatas', $steps);
		}
		else{
			$steps = $session->get('questionnairedatas',array());
			$steps[$step] = $questionnairedata;
			$session->set('questionnairedatas', $steps);
		}
	}
	
	/**
	 * Save questionnaire data.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public function saveData()
	{
		$app = JFactory::getApplication();
		$formdata = $app->input->post->get('jform', array(), 'array');
		$session = JFactory::getSession();		
		$questionnairedatas = $session->get( 'questionnairedatas');
		
		$bytes = random_bytes(30);
		$uniqueid = bin2hex($bytes);	
		
		$session->clear( 'questionnairedatas');
		
		$date = date("Y-m-d H:i:s");

		if(isset($formdata['respondent'])){
			$respondentdata = (json_decode(json_encode($formdata['respondent']), FALSE));
			echo gettype($respondentdata);
			$respondentdata->created = $date;
			$respondentdata->uniqueid = $uniqueid;
			$respondentdata->description = '';
			$respondentdata->image = '';
			$respondentdata->metakey = '';
			$respondentdata->params = '';
			// Insert the object into the respondent table.
			if($result = JFactory::getDbo()->insertObject('#__jmgquestionnaire_respondents', $respondentdata)){
				JFactory::getApplication()->enqueueMessage(JText::_('COM_JMGQUESTIONNAIRE_RESPONDENT_DATA_INSERTED'));
			}
		}
		
		foreach($questionnairedatas as $questionnairedata){
			$invitationid = $questionnairedata->invitationid;
			foreach($questionnairedata->questions as $question){
				if(isset($question->answers)){
					foreach($question->answers as $answer){
						$question->questionnaireid = $questionnairedata->id;
						$question->answerid = $answer;
						$question->userid = $questionnairedata->userid;
						$question->uniqueid = $uniqueid;
						$question->invitationid = $invitationid;
						$question->created = $date;
						$question->answer = '';

						// Insert the object into the questionnaire key table.
						if($result = JFactory::getDbo()->insertObject('#__jmgquestionnaire_surveys', $question)){
							JFactory::getApplication()->enqueueMessage(JText::_('COM_JMGQUESTIONNAIRE_KEYS_INSERTED'));
						}
					}				
				}
				else if(isset($question->answer) && $question->answer != ''){
					$question->questionnaireid = $questionnairedata->id;
					$question->answer = $question->answer;
					$question->userid = $questionnairedata->userid;
					$question->uniqueid = $uniqueid;
					$question->invitationid = $invitationid;
					$question->created = $date;

					// Insert the object into the questionnaire key table.
					if($result = JFactory::getDbo()->insertObject('#__jmgquestionnaire_surveys', $question)){
						JFactory::getApplication()->enqueueMessage(JText::_('COM_JMGQUESTIONNAIRE_KEYS_INSERTED'));
					}
				}
			}
		}
		return $uniqueid;
	}
}
