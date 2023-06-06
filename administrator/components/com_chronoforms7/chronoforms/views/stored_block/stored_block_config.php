<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui segment basic message grey tab unit-config active" data-tab="unit-<?php echo $n; ?>">
	
	<div class="ui top attached tabular menu small G3-tabs">
		<a class="item active" data-tab="unit-<?php echo $n; ?>-basic"><?php el3('Basic'); ?></a>
	</div>
	
	<div class="ui bottom attached tab segment active" data-tab="unit-<?php echo $n; ?>-basic">
		<div class="field">
			<label><?php el3('Block title'); ?></label>
			<select name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][block_id]" class="ui fluid dropdown" data-keepnonexistent="1">
				<option value="">===</option>
				<?php foreach($this->get('blocks') as $block): ?>
					<?php if(!empty($block['Block']['block_id']) AND $block['Block']['type'] == $utype): ?>
					<option value="<?php echo $block['Block']['block_id']; ?>"><?php echo $block['Block']['title']; ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
		</div>
		
	</div>
	
</div>