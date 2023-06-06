<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="equal width fields">
	<div class="field">
		<label><?php el3('Cart ID'); ?></label>
		<input type="text" value="<?php echo $unit['name']; ?>" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][cart][id]" />
		<small><?php el3('Identifier for the Cart session variable'); ?></small>
	</div>
	<div class="field">
		<label><?php el3('Action'); ?></label>
		<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][cart][mode]" class="ui fluid dropdown" placeholder="">
			<option value=""><?php el3('Set Data'); ?></option>
			<option value="clear"><?php el3('Clear'); ?></option>
		</select>
		<small><?php el3('Action applied to the cart data'); ?></small>
	</div>
</div>
<div class="field">
	<label><?php el3('Products List'); ?></label>
	<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
			'groups' => ['products'],
			'items' => !empty($unit['products']) ? $unit['products'] : null,
			'btns' => ['products' => ['main' => ['text' => rl3('Add New Product')]]],
			'divider' => true,
			'inputs' => [
				'products' => [
					'main' => [
						'r1' => [
							[
								'width' => 'five wide', 
								'type' => 'text',
								'desc' => rl3('Product ID'),
								'params' => [
									'placeholder' => rl3('Product#'),
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][products][#products#][id]', 'value' => 'p#products#']
								],
								
							],
							[
								'width' => 'four wide', 
								'type' => 'text',
								'desc' => rl3('Quantity'),
								'params' => [
									'placeholder' => rl3('Quantity'),
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][products][#products#][quantity]', 'value' => '1']
								],
								
							],
							[
								'width' => 'five wide', 
								'type' => 'text',
								'desc' => rl3('Price'),
								'params' => [
									'placeholder' => rl3('Price'),
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][products][#products#][price]', 'value' => '1.00']
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
						'r2' => [
							[
								'width' => 'eight wide', 
								'type' => 'text',
								'desc' => rl3('Product Name'),
								'params' => [
									'placeholder' => rl3('Product Name'),
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][products][#products#][name]', 'value' => 'Product_#products#']
								],
								
							],
							[
								'width' => 'eight wide', 
								'type' => 'text',
								'desc' => rl3('Description'),
								'params' => [
									'placeholder' => rl3('Description'),
									'origin' => ['name' => 'Connection['.$utype.']['.$n.'][products][#products#][description]']
								],
								
							],
						],
						'r3' => [
							[
								'type' => 'require',
								'file' => dirname(__FILE__).DS.'values_config.php',
								'vars' => ['n' => $n, 'utype' => $utype],
							],
						],
					],
				],
			]
		]);
	?>
</div>