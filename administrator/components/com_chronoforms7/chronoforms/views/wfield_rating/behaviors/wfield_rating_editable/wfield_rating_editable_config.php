<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields inline">
    <div class="field">
        <div class="ui checkbox toggle">
            <input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-interactive]" data-ghost="1" value="0">
            <input type="checkbox" checked="checked" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-interactive]" value="1">
            <label><?php el3('Editable'); ?></label>
            <small><?php el3('The rating can be changed by user'); ?></small>
        </div>
    </div>
    <div class="field">
        <div class="ui checkbox toggle">
            <input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-clearable]" data-ghost="1" value="0">
            <input type="checkbox" checked="checked" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][data-clearable]" value="1">
            <label><?php el3('Clearable'); ?></label>
            <small><?php el3('The rating can be cleared by the user'); ?></small>
        </div>
    </div>
</div>