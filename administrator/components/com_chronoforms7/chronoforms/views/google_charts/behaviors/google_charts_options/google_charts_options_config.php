<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Custom chart options'); ?></label>
	<small><a href="https://developers.google.com/chart" target="_blank">https://developers.google.com/chart</a></small>
	<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
			'groups' => ['chart_options'],
			'items' => $unit['chart_options'] ?? [],
			// 'btns' => ['chart_options' => ['main' => ['text' => rl3('Add Table Column')]]],
			'visible' => ['chart_options' => 1],
			'headers' => [
				'chart_options' => [
					['width' => 'seven wide', 'label' => rl3('Option name')],
					['width' => 'seven wide', 'label' => rl3('Option value')],
					['width' => 'two wide', 'label' => ''],
				],
			],
			'inputs' => [
				'chart_options' => [
					'main' => [
						'r1' => [
							[
								'width' => 'seven wide', 
								'params' => [
									'placeholder' => rl3('Option name'), 
									'origin' => ['name' => 'Connection[views]['.$n.'][chart_options][#chart_options#][name]']
								],
							],
							[
								'width' => 'seven wide', 
								'params' => [
									'placeholder' => rl3('Option value'), 
									'origin' => ['name' => 'Connection[views]['.$n.'][chart_options][#chart_options#][value]']
								],
							],
							[
								'width' => 'two wide', 
								'type' => 'btns',
								'btns' => [
									'add' => [],
									'delete' => [],
								]
							],
						],
					],
				],
			]
		]);
	?>
</div>