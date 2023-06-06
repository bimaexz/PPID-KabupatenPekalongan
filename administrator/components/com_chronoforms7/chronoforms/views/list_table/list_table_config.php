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
	<label><?php el3('Table Columns'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
			'groups' => ['columns'],
			'items' => $unit['columns'] ?? [],
			// 'btns' => ['columns' => ['main' => ['text' => rl3('Add Table Column')]]],
			'visible' => ['columns' => 1],
			'headers' => [
				'columns' => [
					['width' => 'three wide', 'label' => rl3('Path')],
					['width' => 'four wide', 'label' => rl3('Header')],
					['width' => 'two wide', 'label' => rl3('Width')],
					['width' => 'three wide', 'label' => rl3('Class')],
					['width' => 'two wide', 'label' => 'Custom Header'],
					['width' => 'two wide', 'label' => ''],
				],
			],
			'inputs' => [
				'columns' => [
					'main' => [
						'r1' => [
							[
								'width' => 'three wide', 
								'params' => [
									'placeholder' => rl3('Name'), 
									'origin' => ['name' => 'Connection[views]['.$n.'][areas][#columns#][name]']
								],
							],
							[
								'width' => 'four wide', 
								'params' => [
									'placeholder' => rl3('Header'), 
									'origin' => ['name' => 'Connection[views]['.$n.'][columns][#columns#][title]']
								],
							],
							[
								'width' => 'two wide', 
								'type' => 'select',
								'options' =>  [
									'' => rl3('Auto'),
									'collapsing' => rl3('Tight'),
									'two wide' => '2/16',
									'three wide' => '3/16',
									'four wide' => '4/16',
									'five wide' => '5/16',
									'six wide' => '6/16',
									'seven wide' => '7/16',
									'eight wide' => '8/16',
									'nine wide' => '9/16',
									'ten wide' => '10/16',
									'eleven wide' => '11/16',
									'twelve wide' => '12/16',
									'thrteen wide' => '13/16',
									'fourteen wide' => '14/16',
								],
								'params' => [
									'placeholder' => '',
									'origin' => ['name' => 'Connection[views]['.$n.'][columns][#columns#][width]']
								],
							],
							[
								'width' => 'three wide', 
								'params' => [
									'placeholder' => rl3('Class'), 
									'origin' => ['name' => 'Connection[views]['.$n.'][columns][#columns#][class]']
								],
							],
							[
								'width' => 'two wide center aligned', 
								'type' => 'checkbox',
								'params' => [
									'value' => '{name} Header',
									'origin' => ['name' => 'Connection[views]['.$n.'][areas][#columns#][before][header]']
								],
							],
							[
								'width' => 'two wide', 
								'type' => 'btns',
								'btns' => [
									'add' => [],
									'delete' => ['hidden' => 1],
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

<?php $this->view($this->get('cf.paths.shared').'refresh_button.php'); ?>