<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Storage path'); ?></label>
		<input type="text" value="{path:front}<?php echo DS.'files'.DS.'pdf'.$n.'.pdf'; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][file_path]">
		<small><?php el3('The server path under which the file will be stored if the storage option is enabled'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Action'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_view]" class="ui fluid dropdown">
			<option value="D"><?php el3('Download'); ?></option>
			<option value="F"><?php el3('Store'); ?></option>
			<option value="I"><?php el3('Inline display'); ?></option>
			<option value="FI"><?php el3('Store and Inline display'); ?></option>
			<option value="FD"><?php el3('Store and download'); ?></option>
			<option value="S"><?php el3('String data'); ?></option>
		</select>
		<small><?php el3('How the resulting file should be processed ?'); ?></small>
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Title'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_title]">
		<small><?php el3('The PDF file title'); ?></small>
	</div>
	
	<div class="field">
		<label><?php el3('Header'); ?></label>
		<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_header]">
		<small><?php el3('The PDF file header'); ?></small>
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Orientation'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_page_orientation]" class="ui fluid dropdown">
			<option value="P"><?php el3('Portrait'); ?></option>
			<option value="L"><?php el3('Landscape'); ?></option>
		</select>
	</div>
	<div class="field">
		<label><?php el3('Page format'); ?></label>
		<input type="text" value="A4" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][pdf_page_format]">
	</div>
</div>

<div class="field">
	<label><?php el3('Content'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'wysiwyg_editor.php', ['n' => $n, 'editor_id' => 'tcpdf_editor', 'name' => 'Connection[functions]['.$n.'][content]', 'editor_enabled' => false]); ?>
	<small><?php el3('Your PDF file content in HTML'); ?></small>
</div>