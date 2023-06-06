<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Data Sources'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'data_sources.php', ['unit' => $unit, 'n' => $n, 'utype' => $utype]); ?>
	<small><?php el3('The source(s) of the table data list'); ?></small>
</div>

<div class="field">
	<label><?php el3('Chart Columns'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
			'groups' => ['columns'],
			'items' => $unit['columns'] ?? [],
			// 'btns' => ['columns' => ['main' => ['text' => rl3('Add Table Column')]]],
			'visible' => ['columns' => 2],
			'headers' => [
				'columns' => [
					['width' => 'five wide', 'label' => rl3('Path')],
					['width' => 'nine wide', 'label' => rl3('Title')],
					['width' => 'two wide', 'label' => ''],
				],
			],
			'inputs' => [
				'columns' => [
					'main' => [
						'r1' => [
							[
								'width' => 'five wide', 
								'params' => [
									'placeholder' => rl3('Path'), 
									'origin' => ['name' => 'Connection[views]['.$n.'][columns][#columns#][path]']
								],
							],
							[
								'width' => 'nine wide', 
								'params' => [
									'placeholder' => rl3('Title'), 
									'origin' => ['name' => 'Connection[views]['.$n.'][columns][#columns#][title]']
								],
							],
							[
								'width' => 'two wide', 
								'type' => 'btns',
								'btns' => [
									'add' => [],
									'delete' => ['hidden' => 2],
									'sort' => [],
								]
							],
						],
					],
				],
			]
		]);
	?>
</div>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Type'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][chart][type]" class="ui fluid dropdown">
			<option value="PieChart"><?php el3('Pie Chart'); ?></option>
			<option value="BarChart"><?php el3('Bar Chart'); ?></option>
		</select>
		<small><?php el3('The Chart type'); ?></small>
	</div>
</div>