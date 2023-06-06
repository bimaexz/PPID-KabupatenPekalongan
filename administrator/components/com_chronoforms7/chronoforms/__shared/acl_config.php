<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Acl profile'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][acl][profile]" class="ui fluid search selection dropdown" data-clearable="1" data-keepnonexistent="1">
			<option value=""><?php el3('Public'); ?></option>
			<?php foreach($this->controller->Acls->list() as $acl): ?>
				<option value="<?php echo $acl['AclProfile']['alias']; ?>"><?php echo $acl['AclProfile']['title']; ?></option>
			<?php endforeach; ?>

			<?php $this->controller->get_connection_data(); ?>
			<?php if(!empty($this->data('Connection.settings.form.acl_profiles', []))): ?>
				<?php foreach($this->data('Connection.settings.form.acl_profiles', []) as $acl): ?>
					<option value="<?php echo $acl['alias']; ?>"><?php echo $acl['title']; ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
		<small><?php el3('Select the ACL profile to activate'); ?></small>
	</div>

	<div class="field">
		<label><?php el3('Owner id value (Optional)'); ?></label>
		<input type="text" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][acl][owner_id]">
		<small><?php el3('The Owner id value for the owner group in the ACL profile selected'); ?></small>
	</div>
</div>