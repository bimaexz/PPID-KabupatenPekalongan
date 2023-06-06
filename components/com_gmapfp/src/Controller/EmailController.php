<?php
	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_0_0F
	* Creation date: Octobre 2020
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

namespace Joomla\Component\Gmapfp\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\String\PunycodeHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\User\User;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;

/**
 * Controller for single contact view
 *
 * @since  1.5.19
 */
class EmailController extends FormController
{
	public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}

	public function submit()
	{
		// Check for request forgeries.
		$this->checkToken();

		$app    = Factory::getApplication();
		$model  = $this->getModel('email');
		$stub   = $this->input->getString('id');
		$id     = (int) $stub;

		// Get the data from POST
		$data = $this->input->post->get('jform', array(), 'array');

		// Get item
		$contact = $model->getItem($id);

		if ($contact === false)
		{
			$this->setMessage($model->getError(), 'error');

			return false;
		}

		// Check for a valid session cookie
		if ($contact->params->get('validate_session', 0))
		{
			if (Factory::getSession()->getState() !== 'active')
			{
				$this->app->enqueueMessage(Text::_('JLIB_ENVIRONMENT_SESSION_INVALID'), 'warning');

				// Save the data in the session.
				$this->app->setUserState('com_gmapfp.email.data', $data);

				// Redirect back to the contact form.
				$this->setRedirect(Route::_('index.php?option=com_gmapfp&view=email&id=' . $stub, false));

				return false;
			}
		}

		// Validate the posted data.
		$form = $model->getForm();

		if (!$form)
		{
			throw new \Exception($model->getError(), 500);

			return false;
		}

		if (!$model->validate($form, $data))
		{
			$errors = $model->getErrors();

			foreach ($errors as $error)
			{
				$errorMessage = $error;

				if ($error instanceof \Exception)
				{
					$errorMessage = $error->getMessage();
				}

				$app->enqueueMessage($errorMessage, 'error');
			}

			$app->setUserState('com_gmapfp.email.data', $data);

			$this->setRedirect(Route::_('index.php?option=com_gmapfp&view=email&id=' . $stub, false));

			return false;
		}

		// Send the email
		$sent = false;

		$sent = $this->_sendEmail($data, $contact, $contact->params->get('show_email_copy', 0));

		$msg = '';

		// Set the success message if it was a success
		if ($sent)
		{
			$msg = Text::_('COM_GMAPFP_EMAIL_THANKS');
		}

		// Flush the data from the session
		$this->app->setUserState('com_gmapfp.email.data', null);

		// Redirect if it is set in the parameters, otherwise redirect back to where we came from
		if ($contact->params->get('redirect'))
		{
			$this->setRedirect($contact->params->get('redirect'), $msg);
		}
		else
		{
			$this->setRedirect(Route::_('index.php?option=com_gmapfp&view=email&id=' . $stub, false), $msg);
		}

		return true;
	}

	private function _sendEmail($data, $contact, $copy_email_activated)
	{
		$app = $this->app;

		if ($contact->email == '' && $contact->user_id != 0)
		{
			$contact_user      = User::getInstance($contact->user_id);
			$contact->email = $contact_user->get('email');
		}

		$mailfrom = $app->get('mailfrom');
		$fromname = $app->get('fromname');
		$sitename = $app->get('sitename');

		$name    = $data['name'];
		$email   = PunycodeHelper::emailToPunycode($data['email']);
		$subject = $data['subject'];
		$body    = $data['message'];

		// Prepare email body
		$prefix = Text::sprintf('COM_GMAPFP_ENQUIRY_TEXT', Uri::base());
		$body   = $prefix . "\n" . $name . ' <' . $email . '>' . "\r\n\r\n" . stripslashes($body);

		try
		{
			$mail = Factory::getMailer();
			$mail->addRecipient($contact->email_to);
			$mail->addReplyTo($email, $name);
			$mail->setSender(array($mailfrom, $fromname));
			$mail->setSubject($sitename . ': ' . $subject);
			$mail->setBody($body);
			$sent = $mail->Send();

			// If we are supposed to copy the sender, do so.

			// Check whether email copy function activated
			if ($copy_email_activated == true && !empty($data['email_copy']))
			{
				$copytext = Text::sprintf('COM_GMAPFP_COPYTEXT_OF', $contact->name, $sitename);
				$copytext .= "\r\n\r\n" . $body;
				$copysubject = Text::sprintf('COM_GMAPFP_COPYSUBJECT_OF', $subject);

				$mail = Factory::getMailer();
				$mail->addRecipient($email);
				$mail->addReplyTo($email, $name);
				$mail->setSender(array($mailfrom, $fromname));
				$mail->setSubject($copysubject);
				$mail->setBody($copytext);
				$sent = $mail->Send();
			}
		}
		catch (\Exception $exception)
		{
			try
			{
				Log::add(Text::_($exception->getMessage()), Log::WARNING, 'jerror');

				$sent = false;
			}
			catch (\RuntimeException $exception)
			{
				Factory::getApplication()->enqueueMessage(Text::_($exception->errorMessage()), 'warning');

				$sent = false;
			}
		}

		return $sent;
	}
}
