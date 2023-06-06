<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jmgquestionnaire
 *
 * @copyright   Copyright (C) 2021 - 2027 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="jmg-copyright">
	<?php if (preg_match('/^[A-Z0-9]{10}+$/', $this->params->get('regkey'))) : ?>
	<!--CFR43BH6GT-<?php echo $this->params->get('regkey'); ?>-78GhtBfa6F-->
	<?php else : ?>
	<a href="https://www.shop.framotec.com/joomla/komponenten/72/jmg-questionnaire?c=16" target="_blank">Powered by JooMega</a>
	<?php endif; ?>
</div>