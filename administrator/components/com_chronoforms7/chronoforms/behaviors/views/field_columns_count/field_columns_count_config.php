<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
    <label><?php el3('Number of Columns'); ?></label>
    <select name="Connection[views][<?php echo $n; ?>][columns]" class="ui fluid dropdown" data-clearable="1">
        <option value=""><?php el3('One'); ?></option>
        <option value="2"><?php el3('Two'); ?></option>
        <option value="3"><?php el3('Three'); ?></option>
        <option value="4"><?php el3('Four'); ?></option>
        <option value="5"><?php el3('Five'); ?></option>
        <option value="6"><?php el3('Six'); ?></option>
        <option value="7"><?php el3('Seven'); ?></option>
    </select>
    <small><?php el3('The number of columns at which the options will be displayed'); ?></small>
</div>