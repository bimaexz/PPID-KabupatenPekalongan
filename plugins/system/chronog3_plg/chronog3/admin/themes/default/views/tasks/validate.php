<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
			'title' => rl3('Validate your installation'),
			'class' => 'quti bg-blue800',
	]);
?>

<div class="ui segment bottom attached">
	<?php if((filter_var($domain, FILTER_VALIDATE_IP) !== false) OR (strpos($domain, 'localhost') === 0)): ?>
		<div class="ui green icon message">
			<i class="checkmark icon"></i>
			<div class="content">
				<div class="ui header">
					<?php el3('Your localhost/IP domain qualifies for a free validation!'); ?>
				</div>
				<p>Use your validation key to validate your install for FREE, the key is available in your ChronoEngine.com account</p>
			</div>
		</div>
	<?php endif; ?>

	<div class="field">
		<label>Domain name detected: <input type="text" name="domain_name" freadonly value="<?php echo $domain; ?>"></label>
		<input type="hidden" name="ddddomain_name" value="<?php echo $domain; ?>">
		<small><?php el3('Do not change the domain name unless you are planning to move the website later to a different domain or if your website is accessible under multiple domains.'); ?></small>
	</div>
	<div class="equal width fields">
		<div class="field">
			<label><?php el3('Validation key'); ?></label>
			<input type="text" name="license_key" value="">
			<small><?php el3('Your validation key generated on ChronoEngine.com'); ?></small>
		</div>
		<div class="field">
			<label><?php el3('Serial number (optional)'); ?></label>
			<input type="text" name="serial_number" value="">
			<small><?php el3('You need this key when your website can not connect to chronoengine.com'); ?></small>
		</div>
	</div>
	<button class="ui button compact green icon labeled">
		<i class="faicon check"></i><?php el3('Validate'); ?>
	</button>
	
	<button class="ui button compact yellow icon labeled" name="trial">
		<i class="faicon clock"></i><?php el3('Activate one time trial validation'); ?>
	</button>
	
	<a class="ui button blue compact icon labeled" target="_blank" href="https://www.chronoengine.com/purchase">
		<i class="faicon shopping-cart"></i><?php el3('Purchase Now'); ?>
	</a>
</div>