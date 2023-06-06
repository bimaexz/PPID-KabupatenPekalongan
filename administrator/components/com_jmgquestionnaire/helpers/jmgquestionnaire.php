<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

class JmgQuestionnaireHelper extends JHelperContent
{
	public static function addSubmenu($sbmn)
	{
		$j = new JVersion();
		$jversion = substr($j->getShortVersion(), 0,1);
		if($jversion == 3){
			JHtmlSidebar::addEntry(
				JText::_('COM_JMGQUESTIONNAIRE_SUBMENU_DASHBOARD'),
				'index.php?option=com_jmgquestionnaire&view=jmgquestionnaire',
				$sbmn == 'jmgquestionnaire');

			JHtmlSidebar::addEntry(
				JText::_('COM_JMGQUESTIONNAIRE_SUBMENU_QUESTIONNAIRES'),
				'index.php?option=com_jmgquestionnaire&view=questionnaires',
				$sbmn == 'questionnaires');

			JHtmlSidebar::addEntry(
				JText::_('COM_JMGQUESTIONNAIRE_SUBMENU_QUESTIONS'),
				'index.php?option=com_jmgquestionnaire&view=questions',
				$sbmn == 'questions');

			JHtmlSidebar::addEntry(
				JText::_('COM_JMGQUESTIONNAIRE_SUBMENU_ANSWERS'),
				'index.php?option=com_jmgquestionnaire&view=answers',
				$sbmn == 'answers');
			
			JHtmlSidebar::addEntry(
				JText::_('COM_JMGQUESTIONNAIRE_SUBMENU_RESPONDENTS'),
				'index.php?option=com_jmgquestionnaire&view=respondents',
				$sbmn == 'respondents');

			JHtmlSidebar::addEntry(
				JText::_('COM_JMGQUESTIONNAIRE_SUBMENU_SURVEYS'),
				'index.php?option=com_jmgquestionnaire&view=surveys',
				$sbmn == 'surveys');

			JHtmlSidebar::addEntry(
				JText::_('COM_JMGQUESTIONNAIRE_SUBMENU_CATEGORIES'),
				'index.php?option=com_categories&view=categories&extension=com_jmgquestionnaire',
				$sbmn == 'categories');			
		}

	}
	/**
	 * Adds Count Items for Category Manager.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function countItems(&$items)
	{
		$config = (object) array(
			'related_tbl'   => 'jmgquestionnaire',
			'state_col'     => 'state',
			'group_col'     => 'catid',
			'relation_type' => 'category_or_group',
		);

		return parent::countRelations($items, $config);
	}
	/**
	 * Method to count questionnaires.
	 * @return  int.
	 * @since   1.6
	 */
	public static function getDownloadId(){
		// Get plugin jmg license manager
		$plugin = JPluginHelper::getPlugin('system', 'jmglicensemgr');
		// Check if plugin is enabled
		if ($plugin){
			// Get plugin params
			$pluginParams = new JRegistry($plugin->params);
			$key = $pluginParams->get('key');
			return $key;
		}
	}
	/**
	 * Method to count questionnaires.
	 * @return  int.
	 * @since   1.6
	 */
	public static function countQuestionnaires(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(*)');
		$query->from($db->quoteName('#__jmgquestionnaire_questionnaires'));
		$query->where('state = 1');
		$db->setQuery($query);
		$count = $db->loadResult();
		return $count;
	}
	/**
	 * Method to count questions.
	 * @return  int.
	 * @since   1.6
	 */
	public static function countQuestions(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(*)');
		$query->from($db->quoteName('#__jmgquestionnaire_questions'));
		$query->where('state = 1');
		$query->where('id > 1');
		$db->setQuery($query);
		$count = $db->loadResult();
		return $count;
	}
	/**
	 * Method to count answers.
	 * @return  int.
	 * @since   1.6
	 */
	public static function countAnswers(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(*)');
		$query->from($db->quoteName('#__jmgquestionnaire_answers'));
		$query->where('state = 1');
		$db->setQuery($query);
		$count = $db->loadResult();
		return $count;
	}
	/**
	 * Method to count surveys.
	 * @return  int.
	 * @since   1.6
	 */
	public static function countSurveys(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(*)');
		$query->from($db->quoteName('#__jmgquestionnaire_surveys'));
		$query->group($db->quoteName('uniqueid'));
		$db->setQuery($query);
		$rows = $db->loadObjectList(); 
		$count = count($rows);
		return $count;
	}
	/**
	 * Method to count survey data.
	 * @return  int.
	 * @since   1.6
	 */
	public static function countSurveyData(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(*)');
		$query->from($db->quoteName('#__jmgquestionnaire_surveys'));
		$query->where('state = 1');
		$db->setQuery($query);
		$count = $db->loadResult();
		return $count;
	}
	/**
	 * Method to count categories.
	 * @return  int.
	 * @since   1.6
	 */
	public static function countCategories(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(*)');
		$query->from($db->quoteName('#__jmgquestionnaire_questionnaires'));
		$query->where('state = 1');
		$query->group('catid');
		$db->setQuery($query);
		$count = $db->loadResult();
		return $count;
	}
	/**
	 * Load list of gruops.
	 * @return  stdClass[]
	 ->select(array('a.id AS value',  'CONCAT(c.name, " - ", a.name) AS text'))
	 * @since   3.5
	 */
	public static function getQuestionnairesOptions()
	{
		$options = array();
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('a.id AS value',  'a.name AS text'))
			->from($db->quoteName('#__jmgquestionnaire_questionnaires', 'a'))
			->where($db->quoteName('a.state') . ' = ' . $db->quote(1))
			->order($db->quoteName('a.name') . ' DESC');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		array_unshift($options, JHtml::_('select.option', '', JText::_('COM_JMGQUESTIONNAIRE_SELECT_QUESTIONNAIRE')));

		return $options;
	}
	/**
	 * Load parent question questionning id.
	 * @return  stdClass[]
	 ->select(array('a.id AS value',  'CONCAT(c.name, " - ", a.name) AS text'))
	 * @since   3.5
	 */
	public static function getParentQuestioningIdByParentId($parent_id)
	{
		if($parent_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select('a.questioningid')
				->from($db->quoteName('#__jmgquestionnaire_questions', 'a'))
				->where($db->quoteName('a.id') . ' = ' . $db->quote($parent_id));

			// Get the options.
			$db->setQuery($query);

			try
			{
				$questioningid = $db->loadObject()->questioningid;
			}
			catch (RuntimeException $e)
			{
				JFactory::getApplication()->enqueueMessage();
			}

			return $questioningid;			
		}
	}
	/**
	 * Load list of gruops.
	 * @return  stdClass[]
	 ->select(array('a.id AS value',  'CONCAT(c.name, " - ", a.name) AS text'))
	 * @since   3.5
	 */
	public static function getShowonOptions($questionid,$questioningid)
	{
		$options = array();
		
		if($questioningid == 1 || $questioningid == 2){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select(array('a.id AS value',  'IFNULL(CONCAT("'.JText::_('COM_JMGQUESTIONNAIRE_SHOWON').'", a.name),a.name) AS text'))
				->from($db->quoteName('#__jmgquestionnaire_answers', 'a'))
				->where($db->quoteName('a.state') . ' = ' . $db->quote(1))
				->where($db->quoteName('a.questionid') . ' = ' . $db->quote($questionid))
				->order($db->quoteName('a.ordering') . ' ASC');

			// Get the options.
			$db->setQuery($query);

			try
			{
				$options = $db->loadObjectList();
			}
			catch (RuntimeException $e)
			{
				JFactory::getApplication()->enqueueMessage();
			}			
		}
		if($questioningid == 4){
			array_unshift($options, JHtml::_('select.option', '-1', JText::_('COM_JMGQUESTIONNAIRE_SHOWON').''.JText::_('JYES')));
			array_unshift($options, JHtml::_('select.option', '-2', JText::_('COM_JMGQUESTIONNAIRE_SHOWON').''.JText::_('JNO')));
		}

		array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_JMGQUESTIONNAIRE_SELECT_SHOWON')));

		return $options;
	}
	/**
	 * Load list of questions.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getQuestionsOptions()
	{
		$options = array();
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('a.id AS value',  'a.name AS text'))
			->from($db->quoteName('#__jmgquestionnaire_questions', 'a'))
			->where($db->quoteName('a.state') . ' = ' . $db->quote(1))
			->order($db->quoteName('a.name') . ' DESC');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		array_unshift($options, JHtml::_('select.option', '', JText::_('COM_JMGQUESTIONNAIRE_SELECT_QUESTION')));

		return $options;
	}
	/**
	 * Load list of parent questions.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getParentQuestionsOptions($id)
	{
		$options = array();
		
		$db = JFactory::getDbo();
		
		if($id){
			$where = array($db->quoteName('a.state') . ' = ' . $db->quote(1),
						$db->quoteName('a.questionnaireid') . ' = ' . $db->quote($id),
						$db->quoteName('a.parent_id') . ' = ' . $db->quote(1));
		}
		else{
			$where = array($db->quoteName('a.state') . ' = ' . $db->quote(1),
						   $db->quoteName('a.parent_id') . ' = ' . $db->quote(1));
		}
		
		$query = $db->getQuery(true)
			->select(array('DISTINCT(a.id) AS value',  'a.name AS text', 'a.level', 'a.lft'))
			->from($db->quoteName('#__jmgquestionnaire_questions', 'a'))
			->where($where)
			->order($db->quoteName('a.lft') . ' ASC');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		array_unshift($options, JHtml::_('select.option', 1, JText::_('COM_JMGQUESTIONNAIRE_TOP_LEVEL_QUESTION')));
		
		//echo '<pre>';
		//print_r($options);
		//echo '</pre>';
		//exit;

		return $options;
	}
	/**
	 * Load list of questions of questionnaire.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getQuestionsByQuestionnaireId($id)
	{
		$options = array();
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('a.id AS id', 'a.parent_id AS parent_id', 'a.catid AS catid',  'a.name AS name', 'a.score AS score', 'a.level AS level', 'a.lft AS lft', 'a.rgt AS rgt', 'a.questioningid AS questioningid', 'COUNT(an.id) AS answers'))
			->from($db->quoteName('#__jmgquestionnaire_questions', 'a'))		
			->join('LEFT', $db->quoteName('#__jmgquestionnaire_answers', 'an') . ' ON ' . $db->quoteName('a.id') . ' = ' . $db->quoteName('an.questionid') . ' AND ' . $db->quoteName('an.state') . ' = 1')	
			->where($db->quoteName('a.state') . ' = ' . $db->quote(1))
			->where($db->quoteName('a.questionnaireid') . ' = ' . $db->quote($id))
			->order($db->quoteName('a.lft') . 'ASC')
			->group('a.id');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		return $options;
	}
	/**
	 * Load list of invitations of questionnaire.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getInvitationsByQuestionnaireId($id)
	{
		$options = array();
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('a.id AS id', 'a.email AS email', 'a.invitationid AS invitationid', 'a.created AS created', 's.id AS surveyid', 'COUNT(s.id) AS accepted'))
			->from($db->quoteName('#__jmgquestionnaire_invitations', 'a'))
			->join('LEFT', $db->quoteName('#__jmgquestionnaire_surveys', 's') . ' ON ' . $db->quoteName('a.invitationid') . ' = ' . $db->quoteName('s.invitationid') . ' AND ' . $db->quoteName('s.state') . ' = 1')	
			->where($db->quoteName('a.state') . ' = ' . $db->quote(1))
			->where($db->quoteName('a.questionnaireid') . ' = ' . $db->quote($id))
			->group('a.id');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		return $options;
	}
	/**
	 * Count surveys of question.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function countQuestionSurveys($id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(*)');
		$query->from($db->quoteName('#__jmgquestionnaire_surveys'));
		$query->where('questionid = ' . $id);
		$query->where('state = 1');
		//$query->group('uniqueid');
		$db->setQuery($query);
		$count = $db->loadResult();
		return $count;
	}
	/**
	 * Load list of answers of question.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getAnswersByQuestionId($id)
	{
		$options = array();
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('a.id AS id', 'a.name AS name', 'a.statement AS statement', 'q.score AS score'))
			->from($db->quoteName('#__jmgquestionnaire_answers', 'a'))
			->join('LEFT', $db->quoteName('#__jmgquestionnaire_questions', 'q') . ' ON ' . $db->quoteName('a.questionid') . ' = ' . $db->quoteName('q.id'))
			->where($db->quoteName('a.state') . ' = ' . $db->quote(1))
			->where($db->quoteName('a.questionid') . ' = ' . $db->quote($id))
			->order($db->quoteName('a.ordering') . ' ASC');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		return $options;
	}
	/**
	 * Load name of questionnaire.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getQuestionnaireByQuestionnaireId($id)
	{

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('a.id AS id', 'a.name AS name'))
			->from($db->quoteName('#__jmgquestionnaire_questionnaires', 'a'))
			->where($db->quoteName('a.id') . ' = ' . $db->quote($id));

		// Get the options.
		$db->setQuery($query);

		try
		{
			$questionnaire = $db->loadObject();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		return $questionnaire;
	}
	
	
	
	
	
	
	/**
	 * Load name of questionnaires.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getQuestionnairesByRespondent($id)
	{

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('a.id AS id', 'a.name AS name'))
			->from($db->quoteName('#__jmgquestionnaire_questionnaires', 'a'))
			->where($db->quoteName('a.id') . ' = ' . $db->quote($id));

		// Get the options.
		$db->setQuery($query);

		try
		{
			$questionnaires = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		return $questionnaires;
	}
	
	
	
	
	
	
	
	
	
	/**
	 * Load questionnaire.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getQuestionnaireByQuestionId($id)
	{

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('q.id AS id'))
			->from($db->quoteName('#__jmgquestionnaire_questions', 'a'))
			->join('LEFT', $db->quoteName('#__jmgquestionnaire_questionnaires', 'q') . ' ON ' . $db->quoteName('a.questionnaireid') . ' = ' . $db->quoteName('q.id'))
			->where($db->quoteName('a.id') . ' = ' . $db->quote($id));

		// Get the options.
		$db->setQuery($query);

		try
		{
			$questionnaire = $db->loadObject();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		return $questionnaire;
	}
	/**
	 * Load name of question.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getQuestionByQuestionId($id)
	{

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('a.id AS id', 'a.name AS name', 'a.image AS image', 'a.questioningid AS questioningid'))
			->from($db->quoteName('#__jmgquestionnaire_questions', 'a'))
			->where($db->quoteName('a.id') . ' = ' . $db->quote($id));

		// Get the options.
		$db->setQuery($query);

		try
		{
			$question = $db->loadObject();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		return $question;
	}
	/**
	 * Array of questioning techniques.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getFieldNameByAlias($alias)
	{		
		switch ($alias)
		{
			case 'genderid': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_GENDERID');
			case 'salutation': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_SALUTATION');
			case 'titlex': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_TITLE');
			case 'firstname': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_FIRSTNAME');
			case 'surname': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_SURNAME');
			case 'name': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_NAME');
			case 'street': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_STREET');
			case 'postal_code': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_POSTAL_CODE');
			case 'city': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_CITY');
			case 'stateid': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_STATEID');
			case 'countryid': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_COUNTRYID');
			case 'phone': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_PHONE');
			case 'mobile': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_MOBILE');
			case 'fax': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_FAX');
			case 'email': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_EMAIL');
			case 'website': return JText::_('COM_JMGQUESTIONNAIRE_DEFAULT_FIELD_WEBSITE');
		}
	}
	/**
	 * Array of questioning techniques.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getQuestioningTechniques($questioningid)
	{		
		switch ($questioningid)
		{
			case 1: return JText::_('COM_JMGQUESTIONNAIRE_SINGLE_CHOICE');
			case 2: return JText::_('COM_JMGQUESTIONNAIRE_MULTIPLE_CHOICE');
			case 3: return JText::_('COM_JMGQUESTIONNAIRE_OPEN_QUESTIONS');
			case 4: return JText::_('COM_JMGQUESTIONNAIRE_CLOSED_QUESTIONS');
		}
	}
	/**
	 * Array of statements.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getSatementById($statementid)
	{		
		switch ($statementid)
		{
			case 0: return JText::_('COM_JMGQUESTIONNAIRE_STATEMENT_0');
			case 1: return JText::_('COM_JMGQUESTIONNAIRE_STATEMENT_1');
			case 2: return JText::_('COM_JMGQUESTIONNAIRE_STATEMENT_2');
		}
	}
	/**
	 * Load list of questions and answers of survey.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getSurveyByUniqueId($uniqueid)
	{
		$options = array();
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('a.id AS id', 'a.answerid AS answerid', 'q.name AS questionnaire', 'qe.name AS question', 'qe.questioningid AS questioningid', 'an.name AS answer', 'a.answer AS openanswer', 'an.statement AS statement', 'qe.score AS score'))
			->from($db->quoteName('#__jmgquestionnaire_surveys', 'a'))
			->join('LEFT', $db->quoteName('#__jmgquestionnaire_questionnaires', 'q') . ' ON ' . $db->quoteName('a.questionnaireid') . ' = ' . $db->quoteName('q.id'))
			->join('LEFT', $db->quoteName('#__jmgquestionnaire_questions', 'qe') . ' ON ' . $db->quoteName('a.questionid') . ' = ' . $db->quoteName('qe.id'))
			->join('LEFT', $db->quoteName('#__jmgquestionnaire_answers', 'an') . ' ON ' . $db->quoteName('a.answerid') . ' = ' . $db->quoteName('an.id'))
			->where($db->quoteName('a.state') . ' = ' . $db->quote(1))
			->where($db->quoteName('a.uniqueid') . ' = ' . $db->quote($uniqueid));

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		return $options;
	}
	/**
	 * Load respondent of survey.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getRespondentByUniqueId($uniqueid)
	{

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('a.id AS id', 'a.invitationid AS invitationid', 'r.name AS respondent', 'r.firstname AS firstname', 'r.surname AS surname', 'r.postal_code AS postal_code', 'r.city AS city'))
			->from($db->quoteName('#__jmgquestionnaire_surveys', 'a'))
			->join('LEFT', $db->quoteName('#__jmgquestionnaire_respondents', 'r') . ' ON ' . $db->quoteName('r.uniqueid') . ' = ' . $db->quoteName('a.uniqueid'))
			->where($db->quoteName('a.state') . ' = ' . $db->quote(1))
			->where($db->quoteName('a.uniqueid') . ' = ' . $db->quote($uniqueid))
			->group($db->quoteName('a.uniqueid'));

		// Get the respondent.
		$db->setQuery($query);

		try
		{
			$respondent = $db->loadObject();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		return $respondent;
	}
	/**
	 * Load a record.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getRecordById($id)
	{	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('a.id AS id', 'a.answerid AS answerid', 'q.name AS questionnaire', 'qe.name AS question', 'an.name AS answer', 'a.answer AS openanswer', 'an.statement AS statement', 'an.score AS score'))
			->from($db->quoteName('#__jmgquestionnaire_surveys', 'a'))
			->join('LEFT', $db->quoteName('#__jmgquestionnaire_questionnaires', 'q') . ' ON ' . $db->quoteName('a.questionnaireid') . ' = ' . $db->quoteName('q.id'))
			->join('LEFT', $db->quoteName('#__jmgquestionnaire_questions', 'qe') . ' ON ' . $db->quoteName('a.questionid') . ' = ' . $db->quoteName('qe.id'))
			->join('LEFT', $db->quoteName('#__jmgquestionnaire_answers', 'an') . ' ON ' . $db->quoteName('a.answerid') . ' = ' . $db->quoteName('an.id'))
			->where($db->quoteName('a.state') . ' = ' . $db->quote(1))
			->where($db->quoteName('a.id') . ' = ' . $db->quote($id));

		// Get the record.
		$db->setQuery($query);

		try
		{
			$record = $db->loadObject();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		return $record;
	}
	/**
	 * Load settings of questionnaire.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getQuestionnaireSettingsById($id)
	{
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('a.id AS id','a.notificationid AS notificationid','a.redirectid AS redirectid'))
			->from($db->quoteName('#__jmgquestionnaire_questionnaires', 'a'))
			->where($db->quoteName('a.state') . ' = ' . $db->quote(1))
			->where($db->quoteName('a.id') . ' = ' . $db->quote($id));

		// Get the options.
		$db->setQuery($query);

		try
		{
			$settings = $db->loadObject();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		return $settings;
	}
	/**
	 * Load list of modules.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function getModulesOptions()
	{
		$options = array();
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select(array('a.id AS value',  'a.title AS text'))
			->from($db->quoteName('#__modules', 'a'))
			->where($db->quoteName('a.published') . ' = ' . $db->quote(1))
			->order($db->quoteName('a.title') . ' DESC');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage();
		}

		array_unshift($options, JHtml::_('select.option', '', JText::_('COM_JMGQUESTIONNAIRE_SELECT_GROUP')));

		return $options;
	}
	/**
	 * Method to send an invitation.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function sendInvitation($email,$invitationid,$questionnaireid)
	{
		$config	= JFactory::getConfig();
		$from = array($config->get('mailfrom'), $config->get('fromname'));
		$recipients = array($email);
		$subject = JmgQuestionnaireHelper::getQuestionnaireByQuestionnaireId($questionnaireid)->name;
		$body = array();
		$body[] = '<h3>'.JText::_('COM_JMGQUESTIONNAIRE_INVITATION_TITLE').'</h3>';
		$body[] = '<p>'.JText::_('COM_JMGQUESTIONNAIRE_INVITATION_BODY').'</p>';
		$body[] = '<p>'.JText::_('COM_JMGQUESTIONNAIRE_INVITATION_INFO').': '.$invitationid.'</p>';
		$body[] = '<p><a style="background: #2384d3; border: 20px solid #2384d3; color: #fff; display:block; text-decoration:none; hover:text-decoration:none; active:color:#fff; focus:color:#fff; visited:color:#fff;" href="'.JURI::getInstance()->getHost().'/index.php?option=com_jmgquestionnaire&view=questionnaire&id='.$questionnaireid.'&invitationid='.$invitationid.'">'.JText::_('COM_JMGQUESTIONNAIRE_INVITATION_ACCEPT').'</a></p>';
		$body[] = '<p>'.JText::_('COM_JMGQUESTIONNAIRE_INVITATION_REGARDS').'<br>'.$config->get( 'sitename' ).'</p>';
		$mailer = JFactory::getMailer();
		$mailer->setSender($from);
		$mailer->addRecipient($recipients);
		$mailer->setSubject($subject);
		$mailer->setBody(implode("\n", $body));
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		if($mailer->send()){
			//JFactory::getApplication()->enqueueMessage(JText::_('COM_JMGQUESTIONNAIRE_MAIL_SENT'));
			return true;
		}
		else{
			JFactory::getApplication()->enqueueMessage(JText::_('COM_JMGQUESTIONNAIRE_MAIL_ERROR'),'error');
			return false;
		}
	}
	/**
	 * Check invitation id.
	 * @return  stdClass[]
	 * @since   3.5
	 */
	public static function checkInvitationId($id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(*)');
		$query->from($db->quoteName('#__jmgquestionnaire_invitations'));
		$query->where($db->quoteName('invitationid') . ' = ' . $db->quote($id));
		$db->setQuery($query);
		$count = $db->loadResult();
		return $count;
	}
}
