<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.dbmanager.table_menu');
?>
<div class="ui bottom attached segment">
	<?php foreach($columns as $column): ?>
		<div class="field">
			<label><?php echo $column['name']; ?>&nbsp;<span class="ui text grey small"><?php echo $column['type'].($column['length'] ? '('.$column['length'].')' : ''); ?></span></label>
			<?php if(!empty($column['null'])): ?>
				<div class="ui checkbox" style="margin-top:0;">
					<input type="checkbox" name="Record[<?php echo $column['name']; ?>][null]" class="hidden" value="1" tabindex="0">
					<label><small>Null</small></label>
				</div>
			<?php endif; ?>
			<?php if(in_array($column['type'], ['int', 'tinyint', 'smallint', 'mediumint', 'bigint', 'decimal', 'float', 'double', 'real', 'date', 'datetime', 'timestamp', 'time', 'year'])): ?>
				<input type="text" value="" name="Record[<?php echo $column['name']; ?>][value]">
			<?php elseif(in_array($column['type'], ['char', 'varchar'])): ?>
				<textarea name="Record[<?php echo $column['name']; ?>][value]" rows="3"></textarea>
			<?php elseif(in_array($column['type'], ['text', 'tinytext', 'mediumtext', 'longtext'])): ?>
				<textarea name="Record[<?php echo $column['name']; ?>][value]" rows="10"></textarea>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>