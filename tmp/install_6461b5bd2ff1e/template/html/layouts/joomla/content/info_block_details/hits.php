<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

?>
<div class="hits">
	<div class="article-info-item-wrap" itemprop="itemHits" data-toggle="tooltip" title="<?php echo "Hits"; ?>">
		
		<meta itemprop="interactionCount" content="UserPageVisits:<?php echo $displayData['item']->hits; ?>" />
		<span><?php echo $displayData['item']->hits. ' '. "Views"; ?></span>
	</div>
</div>