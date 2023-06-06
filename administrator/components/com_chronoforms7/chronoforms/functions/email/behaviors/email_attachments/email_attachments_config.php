<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<div class="ui checkbox toggle">
		<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][attachments_disabled]" data-ghost="1" value="">
		<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][attachments_disabled]" value="1">
		<label><?php el3('Disable Attachments'); ?></label>
		<small><?php el3('Fields with Attach behavior will not be attached to this email'); ?></small>
	</div>
</div>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['attachments'],
		'items' => !empty($unit['attachments']) ? $unit['attachments'] : null,
		'btns' => ['attachments' => ['main' => ['text' => rl3('Add New Attachment')]]],
		'inputs' => [
			'attachments' => [
				'main' => [
					'r1' => [
						[
							'width' => 'twelve wide', 
							'params' => [
								'placeholder' => rl3('File Path on the Server'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][attachments][#attachments#][path]']
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