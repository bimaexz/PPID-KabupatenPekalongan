<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Custom Attributes'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
			'groups' => ['attrs'],
			'items' => !empty($unit['attrs']) ? $unit['attrs'] : null,
			'btns' => ['attrs' => ['main' => ['text' => rl3('Add Custom HTML Tag Attribute')]]],
			'inputs' => [
				'attrs' => [
					'main' => [
						'r1' => [
							[
								'width' => 'three wide', 
								'params' => [
									'placeholder' => rl3('Attribute Name'), 
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][attrs][#attrs#][name]']
								],
							],
							[
								'width' => 'nine wide', 
								'params' => [
									'placeholder' => rl3('Attribute Value'), 
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][attrs][#attrs#][value]']
								],
							],
							[
								'width' => 'two wide', 
								'type' => 'select',
								'options' => [
									'' => rl3('Append'),
									'1' => rl3('Override'),
								],
								'params' => [
									'placeholder' => '', 
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][attrs][#attrs#][override]']
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