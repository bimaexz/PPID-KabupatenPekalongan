<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Content'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'wysiwyg_editor.php', ['n' => $n, 'editor_id' => 'html_editor', 'name' => 'Connection[views]['.$n.'][nodes][main][content]', 'editor_enabled' => false]); ?>
	<small><?php el3('Your HTML code should be here'); ?></small>
</div>
