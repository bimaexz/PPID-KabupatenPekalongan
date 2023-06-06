<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
    <button type="button" class="ui button compact green icon labeled mini" data-hint="<?php el3('Enable WYSIWYG editor'); ?>" onclick="jQuery.G3.tinymce.init('#<?php echo $editor_id; ?><?php echo $n; ?>');">
        <i class="faicon font"></i><?php el3('Editor'); ?>
    </button>
    <button type="button" class="ui button compact red icon labeled mini" data-hint="<?php el3('Disable WYSIWYG editor'); ?>" onclick="jQuery.G3.tinymce.remove('#<?php echo $editor_id; ?><?php echo $n; ?>');">
        <i class="faicon align-justify"></i><?php el3('No Editor'); ?>
    </button>
</div>
<textarea name="<?php echo $name; ?>" rows="10" data-editor="<?php echo (int)$editor_enabled; ?>" id="<?php echo $editor_id; ?><?php echo $n; ?>"><?php echo ($content ?? ''); ?></textarea>