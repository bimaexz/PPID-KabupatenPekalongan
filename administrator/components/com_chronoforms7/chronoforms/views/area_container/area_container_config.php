<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
    <label><?php el3('Full Width'); ?></label>
    <select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][class][fluid]" class="ui fluid dropdown" placeholder="">
        <option value="fluid"><?php el3('Yes'); ?></option>
        <option value=""><?php el3('No'); ?></option>
    </select>
</div>