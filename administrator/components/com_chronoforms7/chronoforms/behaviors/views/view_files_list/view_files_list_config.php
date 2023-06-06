<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Files List'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
			'groups' => ['files'],
			'items' => !empty($unit['files']) ? $unit['files'] : null,
			// 'btns' => ['files' => ['main' => ['text' => rl3('Add New File Reference')]]],
			'visible' => ['files' => 1],
			'inputs' => [
				'files' => [
					'main' => [
						'r1' => [
							[
								'width' => 'fourteen wide', 
								'params' => [
									'placeholder' => rl3('Full file URL'), 
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][files][#files#][url]']
								],
							],
							[
								'width' => 'two wide', 
								'type' => 'btns',
								'btns' => [
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
</div>