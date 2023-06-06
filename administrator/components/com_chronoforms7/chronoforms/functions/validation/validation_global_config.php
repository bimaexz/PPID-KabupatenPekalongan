<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Required'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][required]" value="<?php el3('This field is required'); ?>">
	</div>
	<div class="field">
		<label><?php el3('Checked'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][checked]" value="<?php el3('This field is required'); ?>">
	</div>
	<div class="field">
		<label><?php el3('Email'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][email]" value="<?php el3('This field should have a valid Email Address'); ?>">
	</div>
	<div class="field">
		<label><?php el3('URL'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][url]" value="<?php el3('This field should have a valid web address'); ?>">
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Integer'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][integer]" value="<?php el3('This field should have an integer value'); ?>">
	</div>
	<div class="field">
		<label><?php el3('Decimal'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][decimal]" value="<?php el3('This field should have a decimal value'); ?>">
	</div>
	<div class="field">
		<label><?php el3('Number'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][number]" value="<?php el3('This field should have a number'); ?>">
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Regular Expression'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][regExp]" value="<?php el3('This field is not formatted correctly'); ?>">
	</div>
	<div class="field">
		<label><?php el3('Contains'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][contains]" value="<?php el3('This field should contain #value#'); ?>">
	</div>
	<div class="field">
		<label><?php el3('Does not Contain'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][doesntContain]" value="<?php el3('This field should not contain #value#'); ?>">
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Matches'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][match]" value="<?php el3('This field must match #value#'); ?>">
	</div>
	<div class="field">
		<label><?php el3('Different'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][different]" value="<?php el3('This field must have a different value than #value#'); ?>">
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Minimum Length'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][minLength]" value="<?php el3('This field must have at least #value# characters'); ?>">
	</div>
	<div class="field">
		<label><?php el3('Maximum Length'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][maxLength]" value="<?php el3('This field can not be longer than #value# characters'); ?>">
	</div>
</div>

<div class="equal width fields">
	<div class="field">
		<label><?php el3('Minimum Choices'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][minChecked]" value="<?php el3('This field must have at least #value# selections'); ?>">
	</div>
	<div class="field">
		<label><?php el3('Maximum Choices'); ?></label>
		<input type="text" name="Extension[settings][validation][errors][maxChecked]" value="<?php el3('This field must have no more than #value# selections'); ?>">
	</div>
</div>