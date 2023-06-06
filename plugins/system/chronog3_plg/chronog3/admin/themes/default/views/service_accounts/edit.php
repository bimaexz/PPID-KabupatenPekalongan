<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
			'title' => $this->data['UserServiceAccount']['account_id'] ?? rl3('New Service Account'),
			'class' => 'quti bg-cfpcolor',
			'btns' => [
				[
					'color' => 'inverted active',
					'name' => 'apply',
					'url' => r3('index.php?ext=chronoforms&cont=service_accounts&act=edit'),
					'hint' => rl3('Save changes'),
					'icon' => 'check',
					'title' => rl3('Apply'),
				],
				[
					'color' => 'inverted active',
					'href' => r3('index.php?ext=chronoforms&cont=service_accounts'),
					'hint' => rl3('Close'),
					'icon' => 'times',
					'title' => rl3('Close'),
				],
			]
	]);
?>

<div class="ui segment bottom attached">
	<input type="hidden" name="UserServiceAccount[id]" value="0">
	
	<div class="equal width fields">
		<div class="field">
			<label><?php el3('Account ID'); ?></label>
			<input type="text" placeholder="<?php el3('Gmail Address...etc'); ?>" name="UserServiceAccount[account_id]">
			<small><?php el3('The email address of the account'); ?></small>
		</div>

		<div class="field">
			<label><?php el3('Enabled'); ?></label>
			<select name="UserServiceAccount[service]" class="ui fluid dropdown" placeholder="">
				<option value="google">Google</option>
			</select>
			<small><?php el3('Account service'); ?></small>
		</div>
	</div>
	
	<div class="field">
		<label><?php el3('Description'); ?></label>
		<textarea placeholder="<?php el3('Description'); ?>" name="UserServiceAccount[desc]" id="conndesc" rows="2"></textarea>
		<small><?php el3('UserServiceAccount description shown in wizard tooltips.'); ?></small>
	</div>

	<div class="ui divider"></div>

	<div class="equal width fields">
		<div class="field">
			<label><?php el3('Client Secret'); ?></label>
			<input type="text" name="UserServiceAccount[params][credentials][secret]">
			<small><?php el3('Get this from your Google Console'); ?></small>
		</div>
		<div class="field">
			<label><?php el3('Client ID'); ?></label>
			<input type="text" name="UserServiceAccount[params][credentials][id]">
			<small><?php el3('Get this from your Google Console'); ?></small>
		</div>
	</div>
	<div class="field">
		<label><?php el3('Scopes'); ?></label>
		<select name="UserServiceAccount[params][scopes][]" multiple class="ui fluid dropdown search multiple" placeholder="" data-allowadditions="1">
			<option value="https://www.googleapis.com/auth/drive"><?php el3('Google Drive'); ?></option>
		</select>
		<small><?php el3('Authentication Scopes'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Access Token'); ?></label>
		<textarea name="UserServiceAccount[params][token]" rows="15" readonly></textarea>
		<small><?php el3('The access token provided by Google for this authorization'); ?></small>
	</div>
</div>