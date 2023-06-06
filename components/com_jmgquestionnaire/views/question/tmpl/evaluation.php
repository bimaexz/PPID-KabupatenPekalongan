<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmqquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JLoader::register('JmgQuestionnaireHelper', JPATH_ADMINISTRATOR . '/components/com_jmgquestionnaire/helpers/jmgquestionnaire.php');
JHtml::_('stylesheet', 'com_jmgquestionnaire/evaluation/questionnaire.css', array('version' => 'auto', 'relative' => true));
$answers = JmgQuestionnaireHelper::getSurveyByUniqueId($this->state->get('questionnaire.uniqueid'));
?>
<?php if ($this->item->showtitle) : ?>
<div class="item-title">
<h1><?php echo $this->item->name; ?></h1>
</div>
<?php endif; ?>
<div class="jmg-evaluation-body">
<?php foreach ($answers as $i => $answer) : ?>

		<h4>
			<?php echo $answer->question; ?>
		</h4>
		<ul>
			<li>
				<?php if ($answer->answerid == -1) : ?>
				<?php echo JText::_('JYES'); ?>
				<?php elseif ($answer->answerid == -2) : ?>
				<?php echo JText::_('JNO'); ?>
				<?php else: ?>
				<?php echo $answer->answer; ?>
				<?php echo $answer->openanswer; ?> 
				<?php endif; ?>

				<?php if ($answer->statement == 1) : ?>
				<span class="icon-publish" aria-hidden="true"></span>
				<?php endif; ?>	
			</li>
		</ul>

<?php endforeach; ?>
</div>