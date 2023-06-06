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
				<label><?php el3('Data provider'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][data_provider]">
				<small><?php el3('The data set used to generate the chart.'); ?></small>
			</div>
		</div>
		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('X Field name'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][x_field]">
				<small><?php el3('The name of the field to generate the statistic on the X axis.'); ?></small>
			</div>
			<div class="field">
				<label><?php el3('Y Field name'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][y_field]">
				<small><?php el3('The name of the field to generate the statistic on the Y axis.'); ?></small>
			</div>
		</div>
		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('x axis label'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][x_field_title]">
				<small><?php el3('The label on the X axis.'); ?></small>
			</div>
			<div class="field">
				<label><?php el3('y axis label'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][y_field_title]">
				<small><?php el3('The label on the Y axis.'); ?></small>
			</div>
		</div>
		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Chart width'); ?></label>
				<input type="text" value="550" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][width]">
				<small><?php el3('The chart width.'); ?></small>
			</div>
			<div class="field">
				<label><?php el3('Chart height'); ?></label>
				<input type="text" value="600" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][height]">
				<small><?php el3('The chart height.'); ?></small>
			</div>
		</div>
		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Bottom spacing'); ?></label>
				<input type="text" value="100" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][bottom_indent]">
				<small><?php el3('The amount of space left under the x axis for labels.'); ?></small>
			</div>
			<div class="field">
				<label><?php el3('Left spacing'); ?></label>
				<input type="text" value="50" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][left_indent]">
				<small><?php el3('The amount of space to the left of the y axis left for labels.'); ?></small>
			</div>
		</div>
		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Top spacing'); ?></label>
				<input type="text" value="50" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][top_indent]">
				<small><?php el3('The amount of space left above the chart area.'); ?></small>
			</div>
			<div class="field">
				<label><?php el3('Right spacing'); ?></label>
				<input type="text" value="30" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][right_indent]">
				<small><?php el3('The amount of space to the right of the chart.'); ?></small>
			</div>
		</div>
		
		<div class="field">
			<div class="ui checkbox">
				<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][xaxis_labels_rotate]" data-ghost="1" value="">
				<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][xaxis_labels_rotate]" value="1">
				<label><?php el3('Rotate x axis labels'); ?></label>
				<small><?php el3('Rotate the x axis labels to give them more space.'); ?></small>
			</div>
		</div>
		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Axis label color'); ?></label>
				<input type="text" value="black" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][axis_label_color]">
				<small><?php el3('The color of the labels on the axis.'); ?></small>
			</div>
			<div class="field">
				<label><?php el3('Field label color'); ?></label>
				<input type="text" value="blue" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][field_label_color]">
				<small><?php el3('The color of the fields labels.'); ?></small>
			</div>
		</div>
		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Bar label color'); ?></label>
				<input type="text" value="red" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][bar_label_color]">
				<small><?php el3('The color of the values labels on the bars.'); ?></small>
			</div>
			<div class="field">
				<label><?php el3('Bar color'); ?></label>
				<input type="text" value="blue" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][bar_color]">
				<small><?php el3('The bar color.'); ?></small>
			</div>
		</div>
	
	</div>
	
</div>