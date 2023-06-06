<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$icons = [
		1 => ['icon' => 'moon', 'text' => 'The Moon'],
		2 => ['icon' => 'flag', 'text' => 'The Flag'],
		3 => ['icon' => 'futbol', 'text' => 'The Football'],
		4 => ['icon' => 'fish', 'text' => 'The Fish'],
		5 => ['icon' => 'cat', 'text' => 'The Cat'],
		6 => ['icon' => 'dog', 'text' => 'The Dog'],
		7 => ['icon' => 'heart', 'text' => 'The Heart'],
		8 => ['icon' => 'apple-alt', 'text' => 'The Apple'],
		9 => ['icon' => 'cloud', 'text' => 'The Cloud'],
		10 => ['icon' => 'coffee', 'text' => 'The Coffee'],
		11 => ['icon' => 'phone', 'text' => 'The Phone'],
	];
	if(empty($this->data('Extension.settings.secicon.icons'))){
		$this->data('Extension.settings.secicon.icons', $icons, true);
	}
?>
<?php $this->view(\G3\Globals::ext_path('chronoforms', 'admin').'__shared'.DS.'clonable'.DS.'clonable.php', [
	'groups' => ['icons'],
	'items' => $this->data('Extension.settings.secicon.icons'),
	'btns' => ['icons' => ['main' => ['text' => rl3('Add Security Icon')]]],
	'inputs' => [
		'icons' => [
			'main' => [
				'r1' => [
					[
						'width' => 'seven wide', 
						'type' => 'input',
						'params' => [
							'placeholder' => rl3('Icon class'), 
							'data-iconpreview' => '1',
							'origin' => ['name' => 'Extension[settings][secicon][icons][#icons#][icon]']
						],
					],
					[
						'width' => 'seven wide', 
						'params' => [
							'placeholder' => rl3('Icon text'), 
							'origin' => ['name' => 'Extension[settings][secicon][icons][#icons#][text]']
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

<div class="field">
	<label><?php el3('SecIcon Error message'); ?></label>
	<input type="text" value="You did not choose the correct image." name="Extension[settings][secicon][error]">
	<small><?php el3('Error message to display when the secicon check fails'); ?></small>
</div>