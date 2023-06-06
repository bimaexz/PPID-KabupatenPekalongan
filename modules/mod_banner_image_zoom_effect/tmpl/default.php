<?php
/**
* @title		banner image zoom effect
* @website		http://www.joomhome.com
* @copyright	Copyright (C) 2015 joomhome.com. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site; ?>/modules/mod_banner_image_zoom_effect/assets/css/zoomslider.css" />
<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/modules/mod_banner_image_zoom_effect/assets/script/modernizr-2.6.2.min.js"></script>

<style>
	#demo-1 {
		width: <?php echo $width;?>;
		min-height:300px;
	}
	.demo-inner-content {
		margin: <?php echo ($height/2-102.5);?>px auto;
	}
</style>

<div id="demo-1" data-zs-src='[<?php echo $images_string;?>]' data-zs-overlay="dots">
	<div class="demo-inner-content">
		<h1><span><?php echo $title_module;?></span></h1>
		<p><?php echo $description;?></p>
	</div>
</div>

<?php
if ($enable_jQuery == 1) {?>
	<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/modules/mod_banner_image_zoom_effect/assets/script/jquery.min.js"></script>
<?php }?>
<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/modules/mod_banner_image_zoom_effect/assets/script/jquery.zoomslider.min.js"></script>
