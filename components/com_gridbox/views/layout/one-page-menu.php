<?php
/**
* @package   Gridbox
* @author    Balbooa http://www.balbooa.com/
* @copyright Copyright @ Balbooa
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

defined('_JEXEC') or die;

ob_start();
$obj->items->{'item-'.$now} = gridboxHelper::getOptions('one-page');
?>
<div class="ba-item-one-page-menu ba-item" id="item-<?php echo $now++; ?>">
    <div class="ba-menu-wrapper ba-hamburger-menu">
        <div class="main-menu">
            <div class="close-menu">
                <i class="ba-icons ba-icon-close"></i>
            </div>
            <div class="integration-wrapper">
                <ul class="nav menu">
                    <li>
                        <a href="" data-alias="">Home</a>
                    </li>
                    <li>
                        <a href="" data-alias="">About Us</a>
                    </li>
                    <li>
                        <a href="" data-alias="">Services</a>
                    </li>
                    <li>
                        <a href="" data-alias="">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="open-menu">
            <i class="ba-icons ba-icon-menu"></i>
        </div>
    </div>
    <div class="ba-edit-item">
        <span class="ba-edit-wrapper edit-settings">
            <i class="zmdi zmdi-settings"></i>
            <span class="ba-tooltip tooltip-delay">
                <?php echo JText::_("ITEM"); ?>
            </span>
        </span>
        <div class="ba-buttons-wrapper">
            <span class="ba-edit-wrapper">
                <i class="zmdi zmdi-open-in-new open-mobile-menu"></i>
                <span class="ba-tooltip tooltip-delay settings-tooltip">
                    <?php echo JText::_("OPEN"); ?>
                </span>
            </span>
            <span class="ba-edit-wrapper">
                <i class="zmdi zmdi-edit edit-item"></i>
                <span class="ba-tooltip tooltip-delay settings-tooltip">
                    <?php echo JText::_("EDIT"); ?>
                </span>
            </span>
            <span class="ba-edit-wrapper">
                <i class="zmdi zmdi-copy copy-item"></i>
                <span class="ba-tooltip tooltip-delay settings-tooltip">
                    <?php echo JText::_("COPY_ITEM"); ?>
                </span>
            </span>
            <span class="ba-edit-wrapper">
                <i class="zmdi zmdi-globe add-library"></i>
                <span class="ba-tooltip tooltip-delay settings-tooltip">
                    <?php echo JText::_("ADD_TO_LIBRARY"); ?>
                </span>
            </span>
            <span class="ba-edit-wrapper">
                <i class="zmdi zmdi-delete delete-item"></i>
                <span class="ba-tooltip tooltip-delay settings-tooltip">
                    <?php echo JText::_("DELETE_ITEM"); ?>
                </span>
            </span>
            <span class="ba-edit-text">
                <?php echo JText::_("ITEM"); ?>
            </span>
        </div>
    </div>
    <div class="ba-box-model"></div>
    <div class="ba-menu-backdrop"></div>
</div>
<?php
$out = ob_get_contents();
ob_end_clean();