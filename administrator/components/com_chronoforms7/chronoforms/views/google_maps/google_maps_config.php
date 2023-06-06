<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui segment basic message grey tab unit-config active" data-tab="unit-<?php echo $n; ?>">
	
	<div class="ui top attached tabular menu small G3-tabs">
		<a class="item active" data-tab="unit-<?php echo $n; ?>-basic"><?php el3('Basic'); ?></a>
	</div>
	
	<div class="ui bottom attached tab segment active" data-tab="unit-<?php echo $n; ?>-basic">
		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Map width'); ?></label>
				<input type="text" value="500px" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][width]">
			</div>
			<div class="field">
				<label><?php el3('Map height'); ?></label>
				<input type="text" value="500px" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][height]">
			</div>
		</div>
		
		<div class="three fields">
			<div class="field">
				<label><?php el3('Latitude'); ?></label>
				<input type="text" value="51.5" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][lat]">
			</div>
			<div class="field">
				<label><?php el3('Longitude'); ?></label>
				<input type="text" value="-0.2" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][lng]">
			</div>
			<div class="field">
				<label><?php el3('Zoom'); ?></label>
				<input type="text" value="6" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][zoom]">
				<small><?php el3('The starting zoom of the map.'); ?></small>
			</div>
		</div>
		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Places provider'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][places]">
			</div>
		</div>
		
	</div>
	
</div>