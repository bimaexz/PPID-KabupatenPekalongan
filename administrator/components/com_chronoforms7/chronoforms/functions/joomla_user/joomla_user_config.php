<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Account Name'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][name_provider]" class="ui fluid dropdown search" data-list=".inputsList" data-types='["field_text", "field_select", "field_radios", "field_checkboxes"]' data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Select a field or enter a value to be used for the account name'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Account UserName'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][username_provider]" class="ui fluid dropdown search" data-list=".inputsList" data-types='["field_text", "field_select", "field_radios", "field_checkboxes"]' data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Select a field or enter a value to be used for the account username'); ?></small>
	</div>
</div>

<div class="equal width fields">
	<div class="field required">
		<label><?php el3('Account Password'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][password_provider]" class="ui fluid dropdown search" data-list=".inputsList" data-types='["field_text", "field_password"]' data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Select a field or enter a value to be used for the account password'); ?></small>
	</div>
	<div class="field required">
		<label><?php el3('Account Email Address'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][email_provider]" class="ui fluid dropdown search" data-list=".inputsList" data-types='["field_text", "field_select", "field_radios", "field_checkboxes"]' data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('Select a field or enter a value to be used for the account email address'); ?></small>
	</div>
</div>

<div class="equal width fields">
	<!-- <div class="field">
		<label><?php el3('User is Blocked'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][block_provider]" class="ui fluid dropdown search" data-allowadditions="1">
			<option value="1"><?php el3('Yes'); ?></option>
			<option value="0"><?php el3('No'); ?></option>
		</select>
		<small><?php el3('Select the block status or enter a status provider'); ?></small>
	</div> -->
	<div class="field">
		<label><?php el3('Account status'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][status]" class="ui fluid dropdown search">
			<option value="0"><?php el3('Active & Ublocked'); ?></option>
			<option value="1"><?php el3('Active & Blocked'); ?></option>
			<option value="2"><?php el3('Inactive & Blocked'); ?></option>
		</select>
		<small></small>
	</div>
	<div class="field">
		<label><?php el3('Activation Page/URL'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][activationUrl]" class="ui fluid dropdown search" data-list=".pagesList" data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('The page or url on your website to use for the activation link variable.'); ?></small>
		<small><?php el3('You can use {var:%s.activation.link} and {var:%s.activation.token} to get the activation link and tokens respectively', [$unit['name'], $unit['name']]); ?></small>
	</div>
</div>
<?php
	$Group = new \G3\A\M\Group();
	$_groups = $Group->select('flat');
	// $_groups = array_merge([['Group' => ['id' => 'owner', 'title' => rl3('Owner'), '_parents' => []]]], $_groups);
	$groups = [];
	foreach($_groups as $g){
		$groups[$g['Group']['id']] = $g['Group']['title'];
	}
?>
<div class="field">
	<label><?php el3('User Groups'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][groups_provider][]" class="ui fluid multiple dropdown search" data-allowadditions="1">
		<?php foreach($groups as $gid => $gtitle): ?>
		<option value="<?php echo $gid; ?>" <?php if($gid == 2): ?>selected<?php endif; ?>><?php echo $gtitle; ?></option>
		<?php endforeach; ?>
	</select>
	<small><?php el3('Which groups the user will be added to ?'); ?></small>
</div>

<div class="field">
	<label><?php el3('Data override'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'parameters_config.php', ['unit' => $unit, 'utype' => $utype, 'n' => $n, 'name' => 'data_override', 'text' => rl3('Add Field Override'), 'name_label' => rl3('Field name')]); ?>
</div>

<div class="field required">
	<label><?php el3('User exists error'); ?></label>
	<input type="text" value="<?php el3('A user with the same username or email already exists.'); ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][userexists_error]">
	<small><?php el3('Error message displayed when a user with the same username or email address already exists.'); ?></small>
</div>