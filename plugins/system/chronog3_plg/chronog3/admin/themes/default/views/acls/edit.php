<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
			'title' => $this->data['AclProfile']['title'] ?? rl3('New ACL'),
			'class' => 'quti bg-cfpcolor',
			'btns' => [
				[
					'color' => 'inverted active',
					'name' => 'apply',
					'url' => r3('index.php?ext=chronoforms&cont=acls&act=edit'),
					'hint' => rl3('Save changes'),
					'icon' => 'check',
					'title' => rl3('Apply'),
				],
				[
					'color' => 'inverted active',
					'href' => r3('index.php?ext=chronoforms&cont=acls'),
					'hint' => rl3('Close'),
					'icon' => 'times',
					'title' => rl3('Close'),
				],
			]
	]);
?>

<div class="ui segment bottom attached">
	<input type="hidden" name="AclProfile[id]" value="0">
	
	<div class="equal width fields">
		<div class="field">
			<label><?php el3('Title'); ?></label>
			<input type="text" placeholder="<?php el3('Title'); ?>" name="AclProfile[title]">
			<small><?php el3('The acl title as going to appear in the wizard designer.'); ?></small>
		</div>
		
		<div class="field">
			<label><?php el3('Alias'); ?></label>
			<input type="text" name="AclProfile[alias]">
			<small><?php el3('The acl unique alias.'); ?></small>
		</div>

		<div class="field">
			<label><?php el3('Enabled'); ?></label>
			<select name="AclProfile[enabled]" class="ui fluid dropdown" placeholder="">
				<option value="1"><?php el3('Yes'); ?></option>
				<option value=""><?php el3('No'); ?></option>
			</select>
			<small><?php el3('Enable or disable this AclProfile.'); ?></small>
		</div>
	</div>
	
	<div class="field">
		<label><?php el3('Description'); ?></label>
		<textarea placeholder="<?php el3('Description'); ?>" name="AclProfile[desc]" id="conndesc" rows="2"></textarea>
		<small><?php el3('AclProfile description shown in wizard tooltips.'); ?></small>
	</div>

	<?php $this->view('views.permissions_manager2', ['groups' => $this->get('groups')]); ?>
</div>