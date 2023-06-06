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
<div class="social-share-wrapper" itemscope itemtype="http://schema.org/Person">
	<span>Share</span>
	<div class="social-share">
		<div class="social-share-icon">
			<ul>
				<li>
					<a href="#" data-toggle="tooltip" data-placement="top" title="<?php echo JText::_('HELIX_SHARE_FACEBOOK'); ?>" data-type="facebook" data-url="<?php echo JURI::current(); ?>" data-title="<?php echo $displayData->title; ?>" data-description="<?php echo strip_tags($displayData->introtext); ?>" data-media="" class="prettySocial"><i class="fa fa-facebook"></i>
					</a>
				</li>
				<li>					
					<a href="#" data-toggle="tooltip" data-placement="top" title="<?php echo JText::_('HELIX_SHARE_TWITTER'); ?>" data-type="twitter" data-url="<?php echo JURI::current(); ?>" data-description="<?php echo strip_tags($displayData->introtext); ?>" data-via="joomshaper" class="prettySocial">
						<i class="fa fa-twitter"></i>
						
					</a>
				</li>
				<li>
					<a href="#" data-toggle="tooltip" data-placement="top" title="<?php echo JText::_('HELIX_SHARE_GOOGLE_PLUS'); ?>" data-type="googleplus" data-url="<?php echo JURI::current(); ?>" data-description="<?php echo strip_tags($displayData->introtext); ?>" class="prettySocial"><i class="fa fa-google-plus"></i></a>
				</li>

				<li>
					<a href="#" data-toggle="tooltip" data-placement="top" title="<?php echo JText::_('HELIX_SHARE_LINKEDIN'); ?>" data-type="linkedin" data-url="<?php echo JURI::current(); ?>" data-title="<?php echo $displayData->title; ?>" data-description="<?php echo strip_tags($displayData->introtext); ?>" data-via="joomshaper" data-media="" class="prettySocial"><i class="fa fa-linkedin"></i></a>
				</li>
				<li>
					<a href="#" data-toggle="tooltip" data-placement="top" title="<?php echo JText::_('HELIX_SHARE_PINTEREST'); ?>" data-type="pinterest" data-url="<?php echo JURI::current(); ?>" data-description="<?php echo strip_tags($displayData->introtext); ?>" data-media="" class="prettySocial"><i class="fa fa-pinterest"></i></a>

				</li>
			</ul>
		</div>					
	</div>

</div>


