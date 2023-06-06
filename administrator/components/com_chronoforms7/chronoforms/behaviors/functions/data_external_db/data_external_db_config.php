<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('DB Connection'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][dbconn]" class="ui fluid search selection dropdown" data-clearable="1" data-keepnonexistent="1">
		<option value=""><?php el3('Default Database'); ?></option>
		<?php $connection = $this->controller->get_connection_data(); ?>
		<?php if(!empty(\G3\L\Arr::getVal($connection, 'Connection.settings.form.external_dbs', []))): ?>
			<?php foreach(\G3\L\Arr::getVal($connection, 'Connection.settings.form.external_dbs', []) as $dbconn): ?>
				<option value="<?php echo $dbconn['alias']; ?>"><?php echo $dbconn['title']; ?></option>
			<?php endforeach; ?>
		<?php endif; ?>
	</select>
	<small><?php el3('Select the DB Connection to activate'); ?></small>
</div>

<?php $this->view($this->get('cf.paths.shared').'refresh_button.php', ['label' => rl3('Refresh DB Tables list')]); ?>