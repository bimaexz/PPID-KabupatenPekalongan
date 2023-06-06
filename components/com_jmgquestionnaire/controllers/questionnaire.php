<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JLoader::register('JmgQuestionnaireHelper', JPATH_ADMINISTRATOR . '/components/com_jmgquestionnaire/helpers/jmgquestionnaire.php');
//JLoader::register('JmgFormsController', JPATH_COMPONENT . '/controller.php');

/**
 * Registration controller class for Forms.
 * @since  1.6
 */
class JmgQuestionnaireControllerQuestionnaire extends JControllerForm
{
	/**
	 * Method to submit.
	 * @return  boolean  True on success, false on failure.
	 * @since   1.6
	 */
	public function submit()
	{
		$joomla_captcha = JFactory::getConfig()->get('captcha');
		$jpost = JFactory::getApplication()->input->post;
		if ( $joomla_captcha != '0' ) {		 
			$reCaptcha = $jpost->get("g-recaptcha-response");
		}
		if ( isset( $reCaptcha ) && empty( $reCaptcha )) { 
			JFactory::getApplication()->enqueueMessage(JText::_('COM_JMGQUESTIONNAIRE_INVALID_CAPTCHA')); 
		} 
		else{
			// Check for request forgeries.
			$this->checkToken();
			$model = $this->getModel('Questionnaire', 'JmgQuestionnaireModel');
			//$model->sendMail();
			$uniqueid = $model->saveData();	
		}
		$data = $jpost->get('jform', array(), 'array');
		$settings = JmgQuestionnaireHelper::getQuestionnaireSettingsById($data['questionnaire']['id']);
		
		switch ($settings->notificationid)
		{
			case 0:	
				$this->setRedirect(JRoute::_('index.php?option=com_jmgquestionnaire&view=questionnaire&layout=notification&id='.$data['questionnaire']['id'].'&uniqueid='.$uniqueid, false));
			break;	
					
			case 1:	
				$this->setRedirect(JRoute::_('index.php?option=com_jmgquestionnaire&view=questionnaire&layout=evaluation&id='.$data['questionnaire']['id'].'&uniqueid='.$uniqueid, false));
			break;
					
			case 2:	
				// Redirect to the menu item.
				$this->setRedirect(JRoute::_('index.php?Itemid='.$settings->redirectid), false);
			break;		
		}
		return true;
	}
	
	public function displayForm(){
		echo '';
	}
}
