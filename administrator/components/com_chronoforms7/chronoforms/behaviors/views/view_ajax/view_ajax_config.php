<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="field">
	<label><?php el3('Call Page/URL'); ?></label>
	<select name="Connection[views][<?php echo $n; ?>][ajax][page]" class="ui fluid dropdown search" data-list=".pagesList" data-allowadditions="1" data-clearable="1">
		<option value=""></option>
	</select>
	<small><?php el3('Full URL or form page to be called'); ?></small>
</div>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Response Content'); ?></label>
		<select name="Connection[views][<?php echo $n; ?>][ajax][response]" class="ui fluid dropdown" placeholder="1">
			<option value="ignore"><?php el3('Ignore'); ?></option>
			<option value="replace"><?php el3('Replace Node'); ?></option>
			<option value="content"><?php el3('Update Node HTML'); ?></option>
			<option value="append"><?php el3('Append to Node Children'); ?></option>
			<option value="prepend"><?php el3('Prepend to Node Children'); ?></option>
			<option value="after"><?php el3('Insert After Node'); ?></option>
			<option value="before"><?php el3('Insert Before Node'); ?></option>
		</select>
		<small><?php el3('How the AJAX loaded content will be used'); ?></small>
	</div>

	<div class="field">
		<label><?php el3('AJAX Data Scope'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][ajax][scope]" class="ui fluid dropdown search" data-list=".areasList" data-allowadditions="1" data-clearable="1">
			<option value=""></option>
		</select>
		<small><?php el3('AJAX sends the data of all the form fields, set a different selector to only include the inputs inside'); ?></small>
	</div>
</div>

<div class="field">
	<label><?php el3('Custom URL parameters'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
			'groups' => ['params'],
			'items' => $unit['ajax']['params'] ?? [],
			'btns' => ['params' => ['main' => ['text' => rl3('Add URL Parameter')]]],
			'inputs' => [
				'params' => [
					'main' => [
						'r1' => [
							[
								'width' => 'six wide',
								'params' => [
									'placeholder' => rl3('Parameter name'), 
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][ajax][params][#params#][name]']
								],
							],
							[
								'width' => 'six wide',
								'params' => [
									'placeholder' => rl3('Paremeter value'), 
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][ajax][params][#params#][value]']
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