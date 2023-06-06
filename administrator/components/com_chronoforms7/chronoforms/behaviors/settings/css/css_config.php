<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Content'); ?></label>
	<textarea name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][css][content]" rows="20" data-codeeditor='{"mode":"css"}'></textarea>
	<small><?php el3('CSS code with OUT style tags'); ?></small>
</div>

<div class="field">
	<label><?php el3('Files List'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
			'groups' => ['files'],
			'items' => !empty($unit['css']['files']) ? $unit['css']['files'] : null,
			'btns' => ['files' => ['main' => ['text' => rl3('Load CSS file')]]],
			// 'visible' => ['files' => 1],
			'inputs' => [
				'files' => [
					'main' => [
						'r1' => [
							[
								'width' => 'fourteen wide', 
								'params' => [
									'placeholder' => rl3('Full file URL'), 
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][css][files][#files#][url]']
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