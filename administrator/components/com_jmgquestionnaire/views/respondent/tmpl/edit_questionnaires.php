<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$answers = JmgQuestionnaireHelper::getSurveyByUniqueId($this->item->uniqueid);
?>

<h3><?php echo $answers[0]->questionnaire; ?></h3>

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