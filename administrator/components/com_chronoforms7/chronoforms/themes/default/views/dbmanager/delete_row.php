<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.dbmanager.table_menu');
?>
<div class="ui bottom attached segment">
	<?php foreach($rids as $rid): ?>
		<div class="ui message red">
		DELETE FROM `<?php echo $table; ?>` WHERE `<?php echo $table; ?>`.`<?php echo $uid; ?>` = <?php echo $rid; ?>;
		<input type="hidden" name="rid[]" value="<?php echo $rid; ?>" />
		</div>
	<?php endforeach; ?>
</div>