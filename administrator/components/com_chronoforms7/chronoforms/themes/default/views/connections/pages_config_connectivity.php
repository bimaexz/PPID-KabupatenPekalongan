<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui segment tab event-tab <?php if(!empty($active)): ?>active<?php endif; ?>" data-tab="event-<?php echo $name; ?>">
	
	<div class="ui top attached tabular menu G3-tabs">
		<a class="item active" data-tab="events-<?php echo $name; ?>-general"><?php el3('Settings'); ?></a>
		
		<?php if(!empty($this->data('Connection.params.permissions.app'))): ?>
		<a class="item" data-tab="events-<?php echo $name; ?>-permissions"><?php el3('Permissions'); ?></a>
		<?php endif; ?>
	</div>
	
	<div class="ui bottom attached tab segment active" data-tab="events-<?php echo $name; ?>-general">
		
		<div class="two fields">
			<div class="field">
				<label><?php el3('Name'); ?></label>
				<input type="text" value="<?php echo $name; ?>" name="Connection[events][<?php echo $name; ?>][name]">
			</div>
		</div>
		
		<div class="field">
			<label><?php el3('Content'); ?></label>
			<textarea placeholder="<?php el3('Event content or code'); ?>" name="Connection[events][<?php echo $name; ?>][content]" rows="20" data-codeeditor='{"mode":"html"}'></textarea>
			<small><?php el3('Insert HTML content, call functions and views using {fn:function_name} and {view:view_name}, other variables can be called, please check the instructions guide.'); ?></small>
		</div>
		
	</div>
	
	<?php if(!empty($this->data('Connection.params.permissions.app'))): ?>
	<div class="ui bottom attached tab segment" data-tab="events-<?php echo $name; ?>-permissions">
		<?php if(!empty($this->data('Connection.events.'.$name.'.access_denied'))): ?>
		<div class="two fields">
			<div class="field">
				<label><?php el3('On access denied'); ?></label>
				<input type="text" value="" name="Connection[events][<?php echo $name; ?>][access_denied]">
			</div>
		</div>
		<?php endif; ?>
		
		<div class="two fields">
			<div class="field">
				<label><?php el3('Owner id value'); ?></label>
				<input type="text" value="" name="Connection[events][<?php echo $name; ?>][owner_id]">
			</div>
		</div>
		
		<?php $this->view('views.permissions_manager', ['model' => 'Connection[events]['.$name.']', 'perms' => ['access' => rl3('Access')], 'groups' => $this->get('groups')]); ?>
	</div>
	<?php endif; ?>
	
</div>