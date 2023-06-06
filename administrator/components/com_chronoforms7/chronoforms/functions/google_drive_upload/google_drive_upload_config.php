<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$UserServiceAccount = new \G3\A\M\UserServiceAccount();
	$accounts = $UserServiceAccount->where('user_id', 0)->select('all');
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Google Drive Account'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][account_id]" class="ui fluid dropdown search">
			<?php foreach($accounts as $account): ?>
				<option value="<?php echo $account['UserServiceAccount']['account_id']; ?>"><?php echo $account['UserServiceAccount']['account_id']; ?></option>
			<?php endforeach; ?>
		</select>
		<small><?php el3('Which account should be used to upload the files'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Parent Folder ID'); ?></label>
		<input type="text" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][metadata][parent]">
		<small><?php el3('The parent folder ID, or leave empty to upload to the drive root, the folder id can be found in the browser address bar when you open the folder'); ?></small>
	</div>
</div>