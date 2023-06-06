<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<!-- <select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][data_source]" class="ui fluid dropdown" data-list=".dsourcesList" data-keepnonexistent="1" data-clearable="1">
	<option value=""></option>
</select> -->
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['data_source'],
		'items' => $unit['data_source'] ?? [],
		// 'btns' => ['data_source' => ['main' => ['text' => rl3('Add New Data Source')]]],
		'visible' => ['data_source' => 1],
		'inputs' => [
			'data_source' => [
				'main' => [
					'r1' => [
						[
							'width' => 'ten wide', 
							'type' => 'select',
							'options' => [],
							'params' => [
								'data-list' => '.dsourcesList',
								'data-allowadditions' => '1',
								'data-clearable' => '1',
								'placeholder' => rl3('Choose a Data Source'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][data_source][#data_source#]']
							],
						],
						[
							'width' => 'three wide', 
							'type' => 'btns',
							'btns' => [
								'sort' => [],
								'add' => [],
								'delete' => ['hidden' => 1],
							]
						],
					],
				],
			],
		]
	]);
?>