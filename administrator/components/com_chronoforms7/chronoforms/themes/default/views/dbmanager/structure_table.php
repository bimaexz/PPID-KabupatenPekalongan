<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.dbmanager.table_menu');
?>
<div class="ui bottom attached segment">
<table class="ui single line striped very basic compact selectable table">
	<thead>
		<tr>
			<th><?php el3('Name'); ?></th>
			<th><?php el3('Type'); ?></th>
			<th><?php el3('Attributes'); ?></th>
			<th><?php el3('Null'); ?></th>
			<th><?php el3('Default'); ?></th>
			<th><?php el3('Extra'); ?></th>
			<th><?php el3('Actions'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($columns as $column): ?>
		<tr>
			<td><?php echo $column['name']; ?></td>
			<td><?php echo strtoupper($column['type']).(!empty($column['length']) ? '('.$column['length'].')' : ''); ?></td>
			<td><?php echo $column['attrs']; ?></td>
			<td><?php echo !empty($column['null']) ? rl3('Yes') : rl3('No'); ?></td>
			<td><?php echo !empty($column['default']) ? $column['default'] : (!empty($column['null']) ? 'NULL' : rl3('None')); ?></td>
			<td><?php echo !empty($column['AI']) ? rl3('AUTO_INCREMENT') : ''; ?></td>
			<td>
				<div class="ui floating labeled icon dropdown">
					<i class="faicon ellipsis-h large"></i>
					<div class="menu">
						<div class="item">
							<?php echo $this->Html->a('<i class="faicon edit quti mr-2"></i>'.rl3('Change'), r3('index.php?ext=chronoforms&cont=dbmanager&act=change_column&db='.$db.'&table='.$table.'&column='.$column['name']), []); ?>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>