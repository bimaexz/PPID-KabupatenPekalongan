<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Data Sources'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'data_sources.php', ['unit' => $unit, 'n' => $n, 'utype' => $utype]); ?>
	<small><?php el3('The source(s) of the options data list'); ?></small>
</div>

<?php
	if(empty($unit['dynamic_options']['option_data'])){
		$this->data['Connection'][$utype][$n]['dynamic_options']['option_data'] = [
			1 => ['type' => 'value', 'value' => ''],
			2 => ['type' => 'content', 'value' => ''],
		];
	}
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['option_data'],
		'items' => $unit['dynamic_options']['option_data'] ?? [
			1 => ['type' => 'value', 'value' => ''],
			2 => ['type' => 'content', 'value' => ''],
		],
		'btns' => ['option_data' => ['main' => ['text' => rl3('Add Option Data')]]],
		'headers' => [
			'option_data' => [
				['width' => 'four wide', 'label' => rl3('Option Data Type')],
				['width' => 'ten wide', 'label' => rl3('Option Data Value')],
				['width' => 'two wide', 'label' => ''],
			],
		],
		'inputs' => [
			'option_data' => [
				'main' => [
					'r1' => [
						[
							'width' => 'four wide', 
							'type' => 'select',
							'options' =>  [
								'value' => rl3('Option Value'),
								'content' => rl3('Option Text'),
								'data-icon' => rl3('Icon'),
								'svalue' => rl3('Server Value'),
								// 'data-type' => rl3('Type'),
							],
							'params' => [
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][dynamic_options][option_data][#option_data#][type]']
							],
						],
						[
							'width' => 'ten wide',
							'params' => [
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][dynamic_options][option_data][#option_data#][value]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'btns',
							'btns' => [
								'add' => [],
								'delete' => ['hidden' => 2],
							]
						],
					],
				],
			],
		]
	]);
?>