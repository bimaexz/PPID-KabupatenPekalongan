<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php if(!empty($paginator)): ?>
<div class="quti segment m-0 py-7px px-12px bg-grey200">
	<div style="float:right">
		<?php echo $this->Paginator->info($paginator); ?>
		<?php echo $this->Paginator->navigation($paginator); ?>
		<?php echo $this->Paginator->limiter($paginator); ?>
	</div>
	<div style="clear:both;"></div>
</div>
<?php endif; ?>

<table class="ui table selectable very compact attached <?php echo $class ?? ''; ?> quti m-0 border-0 rounded-0 border-x-1">
	<thead>
		<tr>
			<?php if(!empty($id)): ?>
			<th class="collapsing">
				<div class="ui select_all checkbox">
					<input type="checkbox">
					<label></label>
				</div>
			</th>
			<?php endif; ?>
			<?php foreach($fields as $field): ?>
				<th class="<?php echo $field['class'] ?? ''; ?>">
					<?php if(in_array($field['name'], $this->get('_helpers.sorter.fields', []))): ?>
						<?php echo $this->Sorter->link($field['title'], $field['name']); ?>
					<?php else: ?>
						<?php echo $field['title']; ?>
					<?php endif; ?>
				</th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($rows as $Ri => $Row): ?>
		<tr>
			<?php if(!empty($id)): ?>
			<td class="collapsing">
				<div class="ui checkbox selector">
					<input type="checkbox" class="hidden" name="gcb[]" value="<?php echo \G3\L\Arr::getVal($Row, $id, ''); ?>">
					<label></label>
				</div>
			</td>
			<?php endif; ?>
			<?php foreach($fields as $field): ?>
				<td class="<?php echo $field['class'] ?? ''; ?>">
					<?php echo $field['content']($Row); ?>
				</td>
			<?php endforeach; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="quti segment m-0 py-7px px-12px rounded-b bg-grey200">
	<?php if(!empty($paginator)): ?>
	<div style="float:right">
		<?php echo $this->Paginator->info($paginator); ?>
		<?php echo $this->Paginator->navigation($paginator); ?>
		<?php echo $this->Paginator->limiter($paginator); ?>
	</div>
	<div style="clear:both;"></div>
	<?php endif; ?>
</div>