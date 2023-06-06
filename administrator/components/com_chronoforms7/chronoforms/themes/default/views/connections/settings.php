<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<style>
	<?php if($this->data('Connection.apptype', 'form') == 'contact'): ?>
		.contact-hidden{display:none !important;}
	<?php endif; ?>
</style>

<input type="hidden" name="Connection[id]" value="0">
<!-- <input type="hidden" name="Connection[apptype]" value=""> -->

<input type="hidden" name="Connection[settings][form][uid]" value="form">
<input type="hidden" name="Connection[settings][form][type]" data-ghost="1" value="<?php echo $this->data('Connection.apptype', 'form'); ?>">
<input type="hidden" name="Connection[settings][form][utype]" value="settings">

<div class="ui message top attached" style="margin-top:0;">
	<div class="equal width fields">
		<div class="field">
			<label><?php el3('Title'); ?></label>
			<input type="text" placeholder="<?php el3('Title'); ?>" value="<?php echo \G3\L\Str::camilize($this->data('Connection.apptype', 'form')); ?> <?php echo \G3\L\Dater::datetime('dMy-Hi'); ?>" name="Connection[title]">
		</div>
		<div class="field">
			<label><?php el3('Alias'); ?></label>
			<input type="text" placeholder="<?php el3('Alias'); ?>" name="Connection[alias]">
			<small style="color:red;"><?php el3('Use this alias to call your form in URLs or shortcodes.'); ?></small>
		</div>
	</div>
	<div class="equal width fields">
		<div class="field">
			<label><?php el3('Enabled'); ?></label>
			<select name="Connection[published]" class="ui fluid dropdown">
				<option value="1"><?php el3('Yes'); ?></option>
				<option value="0"><?php el3('No'); ?></option>
			</select>
			<small><?php el3('Enable or disable this form.'); ?></small>
		</div>
		<div class="field">
			<label><?php el3('Type'); ?></label>
			<select name="Connection[apptype]" class="ui fluid dropdown">
				<option value="contact"><?php el3('Contact Form'); ?></option>
				<option value="form"><?php el3('Advanced Form'); ?></option>
				<option value="connectivity"><?php el3('Connectivity Form'); ?></option>
			</select>
			<small><?php el3('Change the form type'); ?></small>
		</div>
	</div>
</div>

<!-- <div class="equal width fields inline">
	<div class="field">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[published]" data-ghost="1" value="">
			<input type="checkbox" checked="checked" class="hidden" name="Connection[published]" value="1">
			<label><?php el3('Published'); ?></label>
			<small><?php el3('Enable or disable this form.'); ?></small>
		</div>
	</div>
	<div class="field contact_hidden">
		<div class="ui checkbox toggle">
			<input type="hidden" name="Connection[settings][404_default]" data-ghost="1" value="">
			<input type="checkbox" checked="checked" class="hidden" name="Connection[settings][404_default]" value="1">
			<label><?php el3('Load default page if accessed page is not found'); ?></label>
			<small><?php el3('If a form page is not found then the default page will be loaded, if this is disabled then a page named 404 will be called'); ?></small>
		</div>
	</div>
</div>

<div class="ui divider"></div> -->

<?php $this->view($this->get('cf.paths.shared').'behaviors_list.php', ['glist' => ['data', 'html', 'admin', 'tasks'], 'unit' => ['utype' => 'settings', 'type' => 'app', 'uid' => 'form']]); ?>