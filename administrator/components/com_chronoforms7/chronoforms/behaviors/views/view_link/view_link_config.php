<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="ten wide field">
		<label><?php el3('Page/URL'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][link_settings][page]" class="ui fluid dropdown search" data-list=".pagesList" data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('A full URL or a Form page to send the user to'); ?></small>
	</div>
	<div class="six wide field">
		<label><?php el3('Target'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][main][attrs][target]" class="ui fluid dropdown" data-clearable="1">
			<option value=""><?php el3('Parent Browser Page'); ?></option>
			<option value="_blank"><?php el3('New Browser page'); ?></option>
		</select>
		<small><?php el3('How the link will open ?'); ?></small>
	</div>
</div>

<div class="field">
	<label><?php el3('Custom URL parameters'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
			'groups' => ['params'],
			'items' => $unit['link_settings']['params'] ?? [],
			'btns' => ['params' => ['main' => ['text' => rl3('Add URL Parameter')]]],
			'inputs' => [
				'params' => [
					'main' => [
						'r1' => [
							[
								'width' => 'six wide',
								'params' => [
									'placeholder' => rl3('Parameter name'), 
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][link_settings][params][#params#][name]']
								],
							],
							[
								'width' => 'six wide',
								'params' => [
									'placeholder' => rl3('Paremeter value'), 
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][link_settings][params][#params#][value]']
								],
							],
							[
								'width' => 'two wide', 
								'type' => 'btns',
								'btns' => [
									'add' => [],
									'delete' => [],
									'sort' => [],
								]
							],
						],
					],
				],
			]
		]);
	?>
	<small><?php el3('List of parameters to be added to the url'); ?></small>
</div>