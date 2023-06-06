<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<div class="ui segment basic message grey tab unit-config active" data-tab="unit-<?php echo $n; ?>">
	
	<div class="ui top attached tabular menu small G3-tabs">
		<a class="item active" data-tab="unit-<?php echo $n; ?>-basic"><?php el3('Basic'); ?></a>
	</div>
	
	<div class="ui bottom attached tab segment active" data-tab="unit-<?php echo $n; ?>-basic">
		<div class="field required">
			<label><?php el3('Address field ID'); ?></label>
			<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][field_id]">
			<small><?php el3('The id of the field used to load the address information from Google.'); ?></small>
		</div>
		
		<div class="field">
			<label><?php el3('Formatted result address field ID'); ?></label>
			<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][formatted_field_id]">
			<small><?php el3('The id of the field to receive the full formatted address result.'); ?></small>
		</div>
		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Street number field ID'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][address][street_number]">
				<small><?php el3('The id of the street number result.'); ?></small>
			</div>
			<div class="field">
				<label><?php el3('Street address field ID'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][address][route]">
				<small><?php el3('The id of the street address result.'); ?></small>
			</div>
		</div>
		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('City name field ID'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][address][locality]">
				<small><?php el3('The id of the city name result.'); ?></small>
			</div>
			<div class="field">
				<label><?php el3('State name field ID'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][address][administrative_area_level_1]">
				<small><?php el3('The id of the state name result.'); ?></small>
			</div>
			<div class="field">
				<label><?php el3('Sub state name field ID'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][address][administrative_area_level_2]">
				<small><?php el3('The id of the sub state name result.'); ?></small>
			</div>
		</div>
		
		<div class="equal width fields">
			<div class="field">
				<label><?php el3('Zip code field ID'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][address][postal_code]">
				<small><?php el3('The id of the zip code result.'); ?></small>
			</div>
			<div class="field">
				<label><?php el3('Country name field ID'); ?></label>
				<input type="text" value="" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][address][country]">
				<small><?php el3('The id of the country name result.'); ?></small>
			</div>
		</div>
		
		<div class="field">
			<div class="ui checkbox toggle red">
				<input type="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][geolocate]" data-ghost="1" value="">
				<input type="checkbox" class="hidden" name="Connection[<?php echo $utype; ?>][<?php echo $n; ?>][geolocate]" value="1">
				<label><?php el3('GeoLocate ?'); ?></label>
				<small><?php el3('If enabled then the user location data will be used, user will get a prompt asking for acceptance.'); ?></small>
			</div>
		</div>
		
	</div>
	
</div>