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
		<small><?php el3('Which account should be used to write the data'); ?></small>
	</div>
	<div class="field required">
		<label><?php el3('SpreadSheet ID'); ?></label>
		<input type="text" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][settings][spreadsheet_id]">
		<small><?php el3('The spreadsheet id can be found in the browser address bar when you open it'); ?></small>
	</div>
</div>
<div class="field required">
	<label><?php el3('Range - Sheet name'); ?></label>
	<input type="text" value="Sheet1" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][settings][range]">
	<small><?php el3('The name of the sheet inside the spreadsheet, may include the cells range'); ?></small>
</div>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['items'],
		'items' => !empty($unit['items']) ? $unit['items'] : null,
		'btns' => ['items' => ['main' => ['text' => rl3('Add New Row')]]],
		'divider' => true,
		'inputs' => [
			'items' => [
				'main' => [
					'r1' => [
						[
							'width' => 'two wide', 
							'type' => 'btns',
							'btns' => [
								'add' => [],
								'delete' => [],
								'sort' => [],
							]
						],
						[
							'width' => 'three wide', 
							'type' => 'add_clone',
							'subgroup' => 'pairs',
							'icon' => 'edit',
							'text' => rl3('Add Value'),
							'color' => 'green',
						],
					],
					'pairs' => [
						[
							'type' => 'require',
							'file' => dirname(__FILE__).DS.'values_config.php',
							'vars' => ['n' => $n, 'utype' => $utype],
						],
					],
				],
			],
		]
	]);
?>