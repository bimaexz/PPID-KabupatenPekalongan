<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

HTMLHelper::_('behavior.multiselect');

$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = 'a.lft';
$listDirn  = 'ASC';
$ordering   = ($listOrder == 'a.lft');
$saveOrder  = ($listOrder == 'a.lft' && strtolower($listDirn) == 'asc');

$j = new JVersion();
$jversion = substr($j->getShortVersion(), 0,1);
if($jversion == 3){
	$saveOrderingUrl = 'index.php?option=com_jmgquestionnaire&task=questions.saveOrderAjax&tmpl=component';
	echo JHtml::_('sortablelist.sortable', 'questionlist', 'adminForm', strtolower($listDirn), $saveOrderingUrl, false, true);
}
else{
	$saveOrderingUrl = 'index.php?option=com_jmgquestionnaire&task=questions.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';
	HTMLHelper::_('draggablelist.draggable');
}
$questionid = JFactory::getApplication()->input->get('questionid');
$questions = JmgQuestionnaireHelper::getQuestionsByQuestionnaireId($this->item->id);
// Prepare a mapping from parent id to the ids of its children
$this->ordering = array();
foreach ($questions as $question)
{
    $this->ordering[$question->parent_id][] = $question->id;
}
$counter = 1;
$subcounter = 0;
$currentnumber = 1;
$subquestnr = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
$this->numbering = array();
foreach($questions as $question){
	if($question->level == 1){
		$this->numbering[$question->id] = $counter++;
	}
}
?>
<form action="" id="adminForm" class="form-inline" name="adminForm" method="post" enctype="multipart/form-data">
	<table class="table table-striped" id="questionlist">
		<thead>
			<tr>
				<th></th>
				<th width="1%" class="center">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>
				<th class="nowrap">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_QUESTION_NR'); ?>
				</th>
				<th class="nowrap">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_QUESTION'); ?>
				</th>
				<th class="nowrap center">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_POINTS'); ?>
				</th>
				<th class="nowrap center">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_ANSWERS'); ?>
				</th>
				<th class="nowrap center">
					<?php echo JText::_('COM_JMGQUESTIONNAIRE_RECEIVED_ANSWERS'); ?>
				</th>
				<td>
				
				</td>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="8">
							
				</td>
			</tr>
		</tfoot>
		<?php if ($jversion == 3) : ?>
		<tbody class="ui-sortable">
		<?php else : ?>
		<tbody <?php if ($saveOrder) :?> class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" 
					 data-direction="<?php echo strtolower($listDirn); ?>" data-nested="false"<?php endif; ?>>
		<?php endif; ?>

<?php foreach ($questions as $i => $question) : ?>
	<?php
	$orderkey   = array_search($question->id, $this->ordering[$question->parent_id]);
	$question->cat_link = JRoute::_('index.php?option=com_categories&extension=com_jmgquestionnaire&task=edit&type=other&cid[]=' . $question->catid);
	$canCreate  = $user->authorise('core.create',     'com_jmgquestionnaire.category.' . $question->catid);
	$canEdit    = $user->authorise('core.edit',       'com_jmgquestionnaire.category.' . $question->catid);
	$canCheckin = $user->authorise('core.manage',     'com_checkin') || $question->checked_out == $userId || $question->checked_out == 0;
	$canChange  = $user->authorise('core.edit.state', 'com_jmgquestionnaire.category.' . $question->catid) && $canCheckin;
					
						// create a list of the parents up the hierarchy to the root 
                        if ($question->level > 1)
                        {
                            $parentsStr = '';
                            $_currentParentId = $question->parent_id;
                            $parentsStr = ' ' . $_currentParentId;
                            for ($j = 0; $j < $question->level; $j++)
                            {
                                foreach ($this->ordering as $k => $v)
                                {
                                    $v = implode('-', $v);
                                    $v = '-' . $v . '-';
                                    if (strpos($v, '-' . $_currentParentId . '-') !== false)
                                    {
                                        $parentsStr .= ' ' . $k;
                                        $_currentParentId = $k;
                                        break;
                                    }
                                }
                            }
                        }
                        else
                        {
                            $parentsStr = '';
                        }
					
	?>		

	
	<?php //$question->cat_link = JRoute::_('index.php?option=com_categories&extension=com_jmgquestionnaire&task=edit&type=other&cid[]=' . $this->question->catid); ?>
	<?php if ($jversion == 3) : ?>
	<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $question->parent_id; ?>"  
		item-id="<?php echo $question->id; ?>" parents="<?php echo $parentsStr; ?>" 
		level="<?php echo $question->level; ?>">
	<?php else : ?>
	<tr class="row<?php echo $i % 2; ?>" data-draggable-group="<?php echo $question->parent_id; ?>"
		data-item-id="<?php echo $question->id; ?>" data-parents="<?php echo $parentsStr; ?>"
		data-level="<?php echo $question->level; ?>">
	<?php endif; ?>
		
		
		<td class="order nowrap center hidden-phone">
			<span class="sortable-handler" style="cursor: move;">
				<span class="icon-menu" aria-hidden="true"></span>
			</span>
			<?php if ($canChange && $saveOrder) : ?>
			<input type="text" style="display:none" name="order[]" size="5"
				value="<?php echo $question->lft; ?>" class="width-20 text-area-order" />
			<?php endif; ?>						
		</td>
		<td class="center">
			<?php echo JHtml::_('grid.id', $i, $question->id); ?>
		</td>
		<td class="nowrap">
			<?php 
			if (isset($this->numbering[$question->id])){
				$currentnumber = $this->numbering[$question->id];
				echo $currentnumber.'.';
				$subcounter = 0;
			}
			else{
				echo $currentnumber.'.'.$subquestnr[$subcounter++].'.';
			}
			?>
		</td>
		<td>
			<?php if ($question->parent_id > 1) : ?>
			 &ndash; 
			<?php endif; ?> 
			<a href="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&task=question.edit&id=' . (int) $question->id); ?>">
			<?php echo $question->name; ?>
			</a>
			<span class="small">
				<?php echo JmgQuestionnaireHelper::getQuestioningTechniques($question->questioningid); ?>						
			</span>
		</td>
		<td class="center">
			<?php if ($question->score) : ?>
				<?php echo $question->score; ?>
			<?php else : ?>
				-  
			<?php endif; ?>
		</td>
		<td class="center">
			<?php if ($question->questioningid == 1 || $question->questioningid == 2) : ?>
				<?php if ($question->answers) : ?>
					<?php echo $question->answers; ?>
				<?php else : ?>
					-  
				<?php endif; ?>
			<?php elseif ($question->questioningid == 3) : ?>
				<?php echo JText::_('COM_JMGQUESTIONNAIRE_FREE_ANSWER'); ?>
			<?php elseif ($question->questioningid == 4) : ?>
				<?php echo JText::_('COM_JMGQUESTIONNAIRE_YES_OR_NO'); ?>
			<?php endif; ?>	
		</td>
		<td class="center">
			<?php $received = JmgQuestionnaireHelper::countQuestionSurveys($question->id); ?>
			<?php if ($received) : ?>
			<?php echo $received; ?>
			<?php else : ?>
				-
			<?php endif; ?>
		</td>
		<td>
			<?php if ($questionid && $questionid == $question->id) : ?>
			<a class="btn btn-small btn-primary" data-id="<?php echo $question->id; ?>"><span class="icon-list-2"> </span></a>
			<?php else : ?>
			<a class="btn btn-small button-save select-question" data-id="<?php echo $question->id; ?>"><span class="icon-list-2"> </span></a>
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>			
	</tbody>
</table>
<input type="hidden" name="task" value="questionnaire.trashquestion" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="jform[id]" id="jform_id" value="<?php echo $this->item->id; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>

<form action="<?php echo JRoute::_('index.php?option=com_jmgquestionnaire&task=questionnaire.questionedit'); ?>" id="questioneditform" class="form-inline" name="questioneditform" method="post" enctype="multipart/form-data">
<input type="hidden" name="option" value="com_jmgquestionnaire" />
<input type="hidden" name="task" value="questionnaire.questionedit" />
<input type="hidden" name="jform[state]" id="jform_state" value="1" />
<input type="hidden" name="jform[description]" id="jform_description" value="" />
<input type="hidden" name="jform[image]" id="jform_image" value="" />
<input type="hidden" name="jform[metakey]" id="jform_metakey" value="" />
<input type="hidden" name="jform[params]" id="jform_params" value="" />
<input type="hidden" name="jform[language]" id="jform_language" value="*" />
<input type="hidden" name="jform[questionid]" id="jform_questionid" value="" />
<input type="hidden" name="jform[id]" id="jform_id" value="<?php echo $this->item->id; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>

