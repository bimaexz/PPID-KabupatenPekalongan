<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$icons = [
		'paper-plane',
		'pencil-alt',
		'trash',
		'times',
		'check',
		'calendar',
		'user',
		'filter',
		'search',
		'angle-left',
		'angle-right',
		'angle-up',
		'angle-down',
		//alert
		'bell',
		'exclamation',
		//arrows
		'reply',
		'redo',
		'sort',
		'retweet',
		'share',
		'sort-up',
		'sort-down',
		'sign-in-alt',
		'sign-out-alt',
		'undo',
		'upload',
		'sync',
		'history',
		//audio
		'pause',
		'music',
		'play',
		'rss',
		//buisiness
		'address-book',
		'address-card',
		'book',
		'archive',
		'briefcase',
		'calculator',
		'chart-line',
		'chart-bar',
		'calendar',
		'copy',
		'cut',
		'edit',
		'file',
		'folder',
		'phone',
		'download',
		'upload',
		'dollar-sign',
		'euro-sign',
		'pound-sign',
		'ruble-sign',
		'won-sign',
		'yen-sign',
		'wrench',
		'heart',
		'pizza-slice',
		'gamepad',
		'mars',
		'venus',
		'thumbs-up',
		'star',
		'gift',
		'globe',
		'male',
		'female',
		'plane',
		'train',
		'ship',
		'futbol',
		'moon',
		'save',
		'shopping-cart',
		'sun',
		'credit-card',
		'lock',
		'unlock',
	];
?>
<div class="field">
	<label><?php el3('Icon'); ?></label>
	<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][nodes][<?php echo $node ?? 'icon'; ?>][attrs][class][icon]" class="ui fluid dropdown search five column" data-clearable="1" data-rich="1" data-allowadditions="1">
		<option value=""><?php el3('None'); ?></option>
		<?php foreach($icons as $icon): ?>
			<option value="<?php echo $icon; ?>" data-html='<i class="faicon <?php echo $icon; ?>"></i>' <?php if(!empty($selected) AND ($selected == $icon)): ?>selected="selected"<?php endif; ?>></option>
		<?php endforeach; ?>
	</select>
</div>