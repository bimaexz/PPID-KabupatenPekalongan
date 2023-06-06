<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_questionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('stylesheet', 'com_jmgquestionnaire/jmgadmin.css', array('version' => 'auto', 'relative' => true));
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$xml = simplexml_load_file(JPATH_ROOT . '/administrator/components/com_jmgquestionnaire/jmgquestionnaire.xml');
$uri = JURI::getInstance();

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$saveOrder = $listOrder == 'a.ordering';

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_jmgquestionnaire&task=questionnaire.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>		
<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&view=questionnaire'); ?>" method="post" name="adminForm" id="adminForm">
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<div class="jmg-row">
			<div class="jmg-col-3">
				<a href="index.php?option=com_jmgquestionnaire&view=questionnaires"><div class="questionnaires">
					<div class="icon"><span class="icon-stack"> </span></div>
					<div class="info">
					<p><?php echo JText::_('COM_JMGQUESTIONNAIRE_SUBMENU_QUESTIONNAIRES'); ?></p>
					<h2><?php echo JmgQuestionnaireHelper::countQuestionnaires(); ?></h2>
					<p><?php echo JmgQuestionnaireHelper::countCategories(); ?> <?php echo JText::_('COM_JMGQUESTIONNAIRE_SUBMENU_CATEGORIES'); ?></p>
					</div>
				</div></a>
			</div>

			<div class="jmg-col-3">
				<a href="index.php?option=com_jmgquestionnaire&view=questions"><div class="questions">
					<div class="icon"><span class="icon-question-2"> </span></div>
					<div class="info">
					<p><?php echo JText::_('COM_JMGQUESTIONNAIRE_SUBMENU_QUESTIONS'); ?></p>
					<h2><?php echo JmgQuestionnaireHelper::countQuestions(); ?></h2>
					<p>100 %</p>
					</div>
				</div></a>
			</div>
			
			<div class="jmg-col-3">
				<a href="index.php?option=com_jmgquestionnaire&view=answers"><div class="answers">
					<div class="icon"><span class="icon-checkmark-circle"> </span></div>
					<div class="info">
					<p><?php echo JText::_('COM_JMGQUESTIONNAIRE_SUBMENU_ANSWERS'); ?></p>
					<h2><?php echo JmgQuestionnaireHelper::countAnswers(); ?></h2>
					<p>100 %</p>
					</div>
				</div></a>
			</div>
			
			<div class="jmg-col-3">
				<a href="index.php?option=com_jmgquestionnaire&view=surveys"><div class="surveys">
					<div class="icon"><span class="icon-chart"> </span></div>
					<div class="info">
					<p><?php echo JText::_('COM_JMGQUESTIONNAIRE_SUBMENU_SURVEYS'); ?></p>
					<h2><?php echo JmgQuestionnaireHelper::countSurveys(); ?></h2> <?php echo JText::_('COM_JMGQUESTIONNAIRE_RESPONDENTS'); ?>
					<p><?php echo JmgQuestionnaireHelper::countSurveyData(); ?> <?php echo JText::_('COM_JMGQUESTIONNAIRE_COUNT_ANSWERS'); ?></p>
					</div>
				</div></a>
			</div>
		</div>
		
		<div class="jmg-row">
			<div class="jmg-col-3">
				<a href="index.php?option=com_jmgquestionnaire&view=questionnaire&layout=edit"><div class="add-questionnaire">
					<div class="add-icon"><span class="icon-plus-2"> </span></div>
					<div class="add-button">
					<p><?php echo JText::_('COM_JMGQUESTIONNAIRE_ADD_QUESTIONNAIRE'); ?></p>
					</div>
				</div></a>	
			</div>
			<div class="jmg-col-3">
				<a href="index.php?option=com_jmgquestionnaire&view=question&layout=edit"><div class="add-question">
					<div class="add-icon"><span class="icon-plus-2"> </span></div>
					<div class="add-button">
					<p><?php echo JText::_('COM_JMGQUESTIONNAIRE_ADD_QUESTION'); ?></p>
					</div>
				</div></a>	
			</div>
			<div class="jmg-col-3">
				<a href="index.php?option=com_jmgquestionnaire&view=answer&layout=edit"><div class="add-answer">
					<div class="add-icon"><span class="icon-plus-2"> </span></div>
					<div class="add-button">
					<p><?php echo JText::_('COM_JMGQUESTIONNAIRE_ADD_ANSWER'); ?></p>
					</div>
				</div></a>
			</div>
			<div class="jmg-col-3">
				<a href="index.php?option=com_jmgquestionnaire&view=records"><div class="add-survey">
					<div class="add-icon"><span class="icon-database"> </span></div>
					<div class="add-button">
					<p><?php echo JText::_('COM_JMGQUESTIONNAIRE_DISPLAY_RECORDS'); ?></p>
					</div>
				</div></a>
			</div>
		</div>
		
		<div class="jmg-row">
			<div class="jmg-col-6">
				&nbsp;
			</div>
			<div class="jmg-col-3b">
				<div class="infos">
					<div class="icon"><span class="icon-info"> </span></div>
					<div class="info">
					<h3><?php echo JText::_('COM_JMGQUESTIONNAIRE_GETPRO_TITLE'); ?></h3>
					<p><?php echo JText::_('COM_JMGQUESTIONNAIRE_GETPRO'); ?></p>
					<p><a href="https://www.shop.framotec.com/joomla/komponenten/71/jmg-questionnaire-pro-fragebogen-fuer-joomla?c=16" class="btn btn-primary" target="_blank"><?php echo JText::_('COM_JMGQUESTIONNAIRE_GETPRO_BUTTON'); ?></a></p>
					</div>
				</div>
			</div>
			<div class="jmg-col-3b">
				<?php if (!JmgQuestionnaireHelper::getDownloadId()) : ?>
				<div class="infosx alert alert-info">
					<div class="icon"><span class="icon-info"> </span></div>
					<div class="info">
					<h3><?php echo JText::_('COM_JMGQUESTIONNAIRE_DOWNLOAD_ID_MISSING_TITLE'); ?></h3>
					<p><?php echo JText::_('COM_JMGQUESTIONNAIRE_DOWNLOAD_ID_MISSING'); ?></p>
					<p><a href="<?php echo JURI::base(); ?>index.php?option=com_plugins&view=plugins&filter_search=jmg license manager" class="btn btn-info"><?php echo JText::_('COM_JMGQUESTIONNAIRE_DOWNLOAD_ID_MISSING_BUTTON'); ?></a></p>
					</div>
				</div>
				<?php endif; ?>
				<div class="infos">
					<div class="icon"><span class="icon-info"> </span></div>
					<div class="info">
					<h3><?php echo JText::_('COM_JMGQUESTIONNAIRE'); ?></h3>
					<p>Version: <?php echo $xml->version; ?><br>
					Article Nr.: <a href="https://www.shop.framotec.com/joomla/komponenten/72/jmg-questionnaire-online-befragung-multi-step-formular-fuer-joomla-3-und-4?c=16" target="_blank">SW10072</a><br>
					License: 1 Website - Regular License<br>
					Support: 6 Months<br>
					Author: <a href="https://extensions.joomla.org/instant-search/?jed_live%5Bquery%5D=jmg" target="_blank"><?php echo $xml->author; ?></a><br>
					Domain: <?php echo $uri->getHost(); ?></p>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</form>