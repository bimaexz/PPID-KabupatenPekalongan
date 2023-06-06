<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.dbmanager.table_menu');
?>
<div class="ui bottom attached segment">
<table class="ui single line striped very basic compact table">
	<thead>
		<tr>
			<th><?php el3('Column'); ?></th>
			<th><?php el3('Type'); ?></th>
			<th><?php el3('Operator'); ?></th>
			<th><?php el3('Value'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($columns as $column): ?>
		<tr>
			<td><?php echo $column['name']; ?></td>
			<td><?php echo strtoupper($column['type']); ?></td>
			<td>
				<select name="Record[<?php echo $column['name']; ?>][op]" class="ui fluid dropdown" data-clearable="1">
					<option value=""></option>
					<option value="equal">=</option>
					<option value="notequal">!=</option>
					<option value="larger">></option>
					<option value="largerequal">>=</option>
					<option value="smaller"><</option>
					<option value="smallerequal"><=</option>
					<option value="like">LIKE</option>
					<option value="likepart">LIKE %...%</option>
					<option value="notlike">NOT LIKE</option>
					<option value="in">IN</option>
					<option value="notin">NOT IN</option>
					<option value="between">BETWEEN</option>
					<option value="notbetween">NOT BETWEEN</option>
					<option value="null">NULL</option>
					<option value="notnull">NOT NULL</option>
				</select>
			</td>
			<td>
				<input type="text" value="" name="Record[<?php echo $column['name']; ?>][value]">
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<input type="submit" name="search" value="<?php el3('Run Search'); ?>" class="ui button fluid blue icon labeled" />
</div>