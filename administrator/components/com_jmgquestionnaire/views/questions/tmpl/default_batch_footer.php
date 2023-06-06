<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jmgmenucard
 *
 * @copyright   Copyright (C) 2018 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<button type="button" class="btn" onclick="document.getElementById('batch-category-id').value='';document.getElementById('batch-client-id').value='';document.getElementById('batch-language-id').value=''" data-dismiss="modal">
	<?php echo JText::_('JCANCEL'); ?>
</button>
<button type="submit" class="btn btn-success" onclick="Joomla.submitbutton('jmgmenucard.batch');">
	<?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>
</button>