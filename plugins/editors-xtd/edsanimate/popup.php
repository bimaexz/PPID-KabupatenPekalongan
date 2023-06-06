<?php 

/**
  *	Editor Xtended - Animate It!
  * Copyright (C) 2014 eLEOPARD Design Studios Pvt Ltd. All rights reserved

  * This program is free software: you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation, either version 3 of the License, or
  * (at your option) any later version.

  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.

  * You should have received a copy of the GNU General Public License
  * along with this program.  If not, see <http://www.gnu.org/licenses/>.

  * For any other query please contact us at contact[at]eleopard[dot]in
**/
?>
<?php	 
	define( '_JEXEC', 1 );
	defined('_JEXEC') or die;	 
	$ih_name = addslashes( $_GET['ih_name'] ); 	
	$scroll_offset = $_GET['sys_so']; 
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Select your Animation Style:</title>		
	<meta name="viewport"
		content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="assets/animate-animo.css" />
	<link rel="stylesheet" href="assets/style.css" />
</head>
<body	onload="document.body.style.display='';"	dir="ltr">
	<div class="edsai-wrapper">
		<div class="edaai-body">
			<div class="preview-badge">
				<span id="animationSandbox">
					<h1 class="site__title mega animateit-icon"></h1>
				</span>
			</div>
			<form name="edsanimate_form" id="edsanimate_form">
				<div class="edsai-form-wrapper">
					<div class="edsai-tabs">
						<div class="edsai-tab edsai-tab-active">
							<a class="edsai-tab-handler" href="#tab-entry">Entry</a>
						</div>
						<div class="edsai-tab">
							<a class="edsai-tab-handler" href="#tab-exit">Exit</a>
						</div>
						<div class="edsai-tab">
							<a class="edsai-tab-handler" href="#tab-options">Options</a>
						</div>
					</div>
					<div id="tab-entry" class="edsai-tab-content edsai-entry"
						style="display: block;">
						<div class="edsai-form-control-wrapper">
							<label for="entry-animation-type">Animation:</label>
							<div class="edsai-form-control">
								<select id="entry-animation-type" name="entry-animation-type"
									class="full-size">
									<option value="none">None</option>
									<optgroup label="Bouncing Entrances">
										<option value="bounceIn">bounceIn</option>
										<option value="bounceInDown">bounceInDown</option>
										<option value="bounceInLeft">bounceInLeft</option>
										<option value="bounceInRight">bounceInRight</option>
										<option value="bounceInUp">bounceInUp</option>
									</optgroup>
									<optgroup label="Fading Entrances">
										<option value="fadeIn" selected>fadeIn</option>
										<option value="fadeInDown">fadeInDown</option>
										<option value="fadeInDownBig">fadeInDownBig</option>
										<option value="fadeInLeft">fadeInLeft</option>
										<option value="fadeInLeftBig">fadeInLeftBig</option>
										<option value="fadeInRight">fadeInRight</option>
										<option value="fadeInRightBig">fadeInRightBig</option>
										<option value="fadeInUp">fadeInUp</option>
										<option value="fadeInUpBig">fadeInUpBig</option>
									</optgroup>
									<optgroup label="Rotating Entrances">
										<option value="rotateIn">rotateIn</option>
										<option value="rotateInDownLeft">rotateInDownLeft</option>
										<option value="rotateInDownRight">rotateInDownRight</option>
										<option value="rotateInUpLeft">rotateInUpLeft</option>
										<option value="rotateInUpRight">rotateInUpRight</option>
									</optgroup>
									<optgroup label="Sliding Entrances">
										<option value="slideInUp">slideInUp</option>
										<option value="slideInDown">slideInDown</option>
										<option value="slideInLeft">slideInLeft</option>
										<option value="slideInRight">slideInRight</option>
									</optgroup>
									<optgroup label="Zoom Entrances">
										<option value="zoomIn">zoomIn</option>
										<option value="zoomInDown">zoomInDown</option>
										<option value="zoomInLeft">zoomInLeft</option>
										<option value="zoomInRight">zoomInRight</option>
										<option value="zoomInUp">zoomInUp</option>
									</optgroup>
									<optgroup label="Attention Seekers">
										<option value="spinner">Spin</option>
										<option value="bounce">bounce</option>
										<option value="flash">flash</option>
										<option value="rubberBand">rubberBand</option>
										<option value="shake">shake</option>
										<option value="swing">swing</option>
										<option value="tada">tada</option>
										<option value="wobble">wobble</option>
										<option value="jello">jello</option>
										<option value="wiggle">wiggle</option>
										<option value="fade">fade</option>
										<option value="appear">appear</option>
										<option value="grow">grow</option>
										<option value="shrink">shrink</option>
										<option value="push">push</option>
										<option value="pop">pop</option>
										<option value="float">float</option>
										<option value="sink">sink</option>
										<option value="forward">forward</option>
										<option value="backward">backward</option>
									</optgroup>
									<optgroup label="Pulse">
										<option value="pulse">pulse</option>
										<option value="pulseGrow">pulseGrow</option>
										<option value="pulseShrink">pulseShrink</option>
									</optgroup>
									<optgroup label="Rotate">
										<option value="rotate">rotate</option>
										<option value="growRotate">growRotate</option>
									</optgroup>
									<optgroup label="Skew">
										<option value="skew">skew</option>
										<option value="skewForward">skewForward</option>
										<option value="skewBackward">skewBackward</option>
									</optgroup>
									<optgroup label="Wobble">
										<option value="wobbleHorizontal">wobbleHorizontal</option>
										<option value="wobbleVertical">wobbleVertical</option>
										<option value="wobbleToBottomRight">wobbleToBottomRight</option>
										<option value="wobbleToTopRight">wobbleToTopRight</option>
										<option value="wobbleTop">wobbleTop</option>
										<option value="wobbleBottom">wobbleBottom</option>
										<option value="wobbleSkew">wobbleSkew</option>
									</optgroup>
									<optgroup label="Buzz">
										<option value="buzz">buzz</option>
										<option value="buzzOut">buzzOut</option>
									</optgroup>
									<optgroup label="Flippers">
										<option value="flip">flip</option>
										<option value="flipInX">flipInX</option>
										<option value="flipInY">flipInY</option>
									</optgroup>
									<optgroup label="Lightspeed">
										<option value="lightSpeedIn">lightSpeedIn</option>
									</optgroup>
									<optgroup label="Twirl">
										<option value="twirlIn">twirlIn</option>
									</optgroup>
									<optgroup label="Specials">
										<option value="hinge">hinge</option>
										<option value="rollIn">rollIn</option>
									</optgroup>
								</select>
							</div>
						</div>
						<div class="edsai-form-control-wrapper">
							<label for="entry-delay">Delay (in seconds):</label>
							<div class="edsai-form-control">
								<select id="entry-delay" name="entry-delay"
									class="half-size has-custom">
									<option value="0">None</option>
									<option value="0.5">0.5</option>
									<option value="1">1.0</option>
									<option value="1.5">1.5</option>
									<option value="2">2.0</option>
									<option value="2.5">2.5</option>
									<option value="3">3.0</option>
									<option value="3.5">3.5</option>
									<option value="4">4.0</option>
									<option value="4.5">4.5</option>
									<option value="5">5.0</option>
									<option value="5.5">5.5</option>
									<option value="6">6.0</option>
									<option value="custom">Custom</option>
								</select> <input id="entry-delay-custom"
									name="entry-delay-custom" class="half-size custom-field"
									placeholder="Custom Delay e.g. 2.7" />
							</div>
						</div>
						<div class="edsai-form-control-wrapper">
							<label for="entry-duration">Duration (in seconds):</label>
							<div class="edsai-form-control">
								<select id="entry-duration" name="entry-duration"
									class="half-size has-custom">
									<option value="0.5">0.5</option>
									<option value="1">1.0</option>
									<option value="1.5">1.5</option>
									<option value="2">2.0</option>
									<option value="2.5">2.5</option>
									<option value="3">3.0</option>
									<option value="3.5">3.5</option>
									<option value="4">4.0</option>
									<option value="4.5">4.5</option>
									<option value="5">5.0</option>
									<option value="5.5">5.5</option>
									<option value="6">6.0</option>
									<option value="custom">Custom</option>
								</select> <input id="entry-duration-custom"
									name="entry-duration-custom" class="half-size custom-field"
									placeholder="Custom Duration e.g. 3.2" />
							</div>
						</div>
						<div class="edsai-form-control-wrapper">
							<label for="entry-timing">Timing:</label>
							<div class="edsai-form-control">
								<select id="entry-timing" name="entry-timing"
									class="half-size">
									<option value="linear">linear</option>
									<option value="ease">ease</option>
									<option value="ease-in">easeIn</option>
									<option value="ease-out">easeOut</option>
									<option value="ease-in-out">easeInOut</option>
									<option value="cubic-bezier(0.47, 0, 0.745, 0.715)">easeInSine</option>
									<option value="cubic-bezier(0.39, 0.575, 0.565, 1)">easeOutSine</option>
									<option value="cubic-bezier(0.445, 0.05, 0.55, 0.95)">easeInOutSine</option>
									<option value="cubic-bezier(0.55, 0.085, 0.68, 0.53)">easeInQuad</option>
									<option value="cubic-bezier(0.25, 0.46, 0.45, 0.94)">easeOutQuad</option>
									<option value="cubic-bezier(0.455, 0.03, 0.515, 0.955)">easeInOutQuad</option>
									<option value="cubic-bezier(0.55, 0.055, 0.675, 0.19)">easeInCubic</option>
									<option value="cubic-bezier(0.215, 0.61, 0.355, 1)">easeOutCubic</option>
									<option value="cubic-bezier(0.645, 0.045, 0.355, 1)">easeInOutCubic</option>
									<option value="cubic-bezier(0.895, 0.03, 0.685, 0.22)">easeInQuart</option>
									<option value="cubic-bezier(0.165, 0.84, 0.44, 1)">easeOutQuart</option>
									<option value="cubic-bezier(0.77, 0, 0.175, 1)">easeInOutQuart</option>
									<option value="cubic-bezier(0.755, 0.05, 0.855, 0.06)">easeInQuint</option>
									<option value="cubic-bezier(0.23, 1, 0.32, 1)">easeOutQuint</option>
									<option value="cubic-bezier(0.86, 0, 0.07, 1)">easeInOutQuint</option>
									<option value="cubic-bezier(0.95, 0.05, 0.795, 0.035)">easeInExpo</option>
									<option value="cubic-bezier(0.19, 1, 0.22, 1)">easeOutExpo</option>
									<option value="cubic-bezier(1, 0, 0, 1)">easeInOutExpo</option>
									<option value="cubic-bezier(0.6, 0.04, 0.98, 0.335)">easeInCirc</option>
									<option value="cubic-bezier(0.075, 0.82, 0.165, 1)">easeOutCirc</option>
									<option value="cubic-bezier(0.785, 0.135, 0.15, 0.86)">easeInOutCirc</option>
									<option value="cubic-bezier(0.6, -0.28, 0.735, 0.045)">easeInBack</option>
									<option value="cubic-bezier(0.175, 0.885, 0.32, 1.275)">easeOutBack</option>
									<option value="cubic-bezier(0.68, -0.55, 0.265, 1.55)">easeInOutBack</option>																										
								</select>
							</div>
						</div>
					</div>
					<div id="tab-exit" class="edsai-tab-content edsai-exit">
						<div class="edsai-form-control-wrapper">
							<label for="exit-animation-type">Animation:</label>
							<div class="edsai-form-control">
								<select id="exit-animation-type" name="exit-animation-type"
									class="full-size">
									<option value="none">None</option>
									<optgroup label="Bouncing Exits">
										<option value="bounceOut">bounceOut</option>
										<option value="bounceOutDown">bounceOutDown</option>
										<option value="bounceOutLeft">bounceOutLeft</option>
										<option value="bounceOutRight">bounceOutRight</option>
										<option value="bounceOutUp">bounceOutUp</option>
									</optgroup>
									<optgroup label="Fading Exits">
										<option value="fadeOut">fadeOut</option>
										<option value="fadeOutDown">fadeOutDown</option>
										<option value="fadeOutDownBig">fadeOutDownBig</option>
										<option value="fadeOutLeft">fadeOutLeft</option>
										<option value="fadeOutLeftBig">fadeOutLeftBig</option>
										<option value="fadeOutRight">fadeOutRight</option>
										<option value="fadeOutRightBig">fadeOutRightBig</option>
										<option value="fadeOutUp">fadeOutUp</option>
										<option value="fadeOutUpBig">fadeOutUpBig</option>
									</optgroup>
									<optgroup label="Rotating Exits">
										<option value="rotateOut">rotateOut</option>
										<option value="rotateOutDownLeft">rotateOutDownLeft</option>
										<option value="rotateOutDownRight">rotateOutDownRight</option>
										<option value="rotateOutUpLeft">rotateOutUpLeft</option>
										<option value="rotateOutUpRight">rotateOutUpRight</option>
									</optgroup>
									<optgroup label="Sliding Exits">
										<option value="slideOutUp">slideOutUp</option>
										<option value="slideOutDown">slideOutDown</option>
										<option value="slideOutLeft">slideOutLeft</option>
										<option value="slideOutRight">slideOutRight</option>
									</optgroup>
									<optgroup label="Zoom Exits">
										<option value="zoomOut">zoomOut</option>
										<option value="zoomOutDown">zoomOutDown</option>
										<option value="zoomOutLeft">zoomOutLeft</option>
										<option value="zoomOutRight">zoomOutRight</option>
										<option value="zoomOutUp">zoomOutUp</option>
									</optgroup>
									<optgroup label="Attention Seekers">
										<option value="spinner">Spin</option>
										<option value="bounce">bounce</option>
										<option value="flash">flash</option>
										<option value="rubberBand">rubberBand</option>
										<option value="shake">shake</option>
										<option value="swing">swing</option>
										<option value="tada">tada</option>
										<option value="wobble">wobble</option>
										<option value="jello">jello</option>
										<option value="wiggle">wiggle</option>
										<option value="fade">fade</option>
										<option value="appear">appear</option>
										<option value="grow">grow</option>
										<option value="shrink">shrink</option>
										<option value="push">push</option>
										<option value="pop">pop</option>
										<option value="float">float</option>
										<option value="sink">sink</option>
										<option value="forward">forward</option>
										<option value="backward">backward</option>
									</optgroup>
									<optgroup label="Pulse">
										<option value="pulse">pulse</option>
										<option value="pulseGrow">pulseGrow</option>
										<option value="pulseShrink">pulseShrink</option>
									</optgroup>
									<optgroup label="Rotate">
										<option value="rotate">rotate</option>
										<option value="growRotate">growRotate</option>
									</optgroup>
									<optgroup label="Skew">
										<option value="skew">skew</option>
										<option value="skewForward">skewForward</option>
										<option value="skewBackward">skewBackward</option>
									</optgroup>
									<optgroup label="Wobble">
										<option value="wobbleHorizontal">wobbleHorizontal</option>
										<option value="wobbleVertical">wobbleVertical</option>
										<option value="wobbleToBottomRight">wobbleToBottomRight</option>
										<option value="wobbleToTopRight">wobbleToTopRight</option>
										<option value="wobbleTop">wobbleTop</option>
										<option value="wobbleBottom">wobbleBottom</option>
										<option value="wobbleSkew">wobbleSkew</option>
									</optgroup>
									<optgroup label="Buzz">
										<option value="buzz">buzz</option>
										<option value="buzzOut">buzzOut</option>
									</optgroup>
									<optgroup label="Flippers">
										<option value="flip">flip</option>
										<option value="flipOutX">flipOutX</option>
										<option value="flipOutY">flipOutY</option>
									</optgroup>
									<optgroup label="Lightspeed">
										<option value="lightSpeedOut">lightSpeedOut</option>
									</optgroup>
									<optgroup label="Twirl">
										<option value="twirlOut">twirlOut</option>
									</optgroup>
									<optgroup label="Specials">
										<option value="hinge">hinge</option>
										<option value="rollOut">rollOut</option>
									</optgroup>
								</select>
							</div>
						</div>
						<div class="edsai-form-control-wrapper">
							<label for="exit-delay">Delay (in seconds):</label>
							<div class="edsai-form-control">
								<select id="exit-delay" name="exit-delay"
									class="half-size has-custom">
									<option value="0">None</option>
									<option value="0.5">0.5</option>
									<option value="1">1.0</option>
									<option value="1.5">1.5</option>
									<option value="2">2.0</option>
									<option value="2.5">2.5</option>
									<option value="3">3.0</option>
									<option value="3.5">3.5</option>
									<option value="4">4.0</option>
									<option value="4.5">4.5</option>
									<option value="5">5.0</option>
									<option value="5.5">5.5</option>
									<option value="6">6.0</option>
									<option value="custom">Custom</option>
								</select> <input id="exit-delay-custom" name="exit-delay-custom"
									class="half-size custom-field"
									placeholder="Custom Delay e.g. 2.7" />
							</div>
						</div>
						<div class="edsai-form-control-wrapper">
							<label for="exit-duration">Duration (in seconds):</label>
							<div class="edsai-form-control">
								<select id="exit-duration" name="exit-duration"
									class="half-size has-custom">
									<option value="0.5">0.5</option>
									<option value="1">1.0</option>
									<option value="1.5">1.5</option>
									<option value="2">2.0</option>
									<option value="2.5">2.5</option>
									<option value="3">3.0</option>
									<option value="3.5">3.5</option>
									<option value="4">4.0</option>
									<option value="4.5">4.5</option>
									<option value="5">5.0</option>
									<option value="5.5">5.5</option>
									<option value="6">6.0</option>
									<option value="custom">Custom</option>
								</select> <input id="exit-duration-custom"
									name="exit-duration-custom" class="half-size custom-field"
									placeholder="Custom Duration e.g. 3.2" />
							</div>
						</div>
						<div class="edsai-form-control-wrapper">
							<label for="exit-timing">Timing:</label>
							<div class="edsai-form-control">
								<select id="exit-timing" name="exit-timing"
									class="half-size">									
									<option value="linear">linear</option>
									<option value="ease">ease</option>
									<option value="ease-in">easeIn</option>
									<option value="ease-out">easeOut</option>
									<option value="ease-in-out">easeInOut</option>
									<option value="cubic-bezier(0.47, 0, 0.745, 0.715)">easeInSine</option>
									<option value="cubic-bezier(0.39, 0.575, 0.565, 1)">easeOutSine</option>
									<option value="cubic-bezier(0.445, 0.05, 0.55, 0.95)">easeInOutSine</option>
									<option value="cubic-bezier(0.55, 0.085, 0.68, 0.53)">easeInQuad</option>
									<option value="cubic-bezier(0.25, 0.46, 0.45, 0.94)">easeOutQuad</option>
									<option value="cubic-bezier(0.455, 0.03, 0.515, 0.955)">easeInOutQuad</option>
									<option value="cubic-bezier(0.55, 0.055, 0.675, 0.19)">easeInCubic</option>
									<option value="cubic-bezier(0.215, 0.61, 0.355, 1)">easeOutCubic</option>
									<option value="cubic-bezier(0.645, 0.045, 0.355, 1)">easeInOutCubic</option>
									<option value="cubic-bezier(0.895, 0.03, 0.685, 0.22)">easeInQuart</option>
									<option value="cubic-bezier(0.165, 0.84, 0.44, 1)">easeOutQuart</option>
									<option value="cubic-bezier(0.77, 0, 0.175, 1)">easeInOutQuart</option>
									<option value="cubic-bezier(0.755, 0.05, 0.855, 0.06)">easeInQuint</option>
									<option value="cubic-bezier(0.23, 1, 0.32, 1)">easeOutQuint</option>
									<option value="cubic-bezier(0.86, 0, 0.07, 1)">easeInOutQuint</option>
									<option value="cubic-bezier(0.95, 0.05, 0.795, 0.035)">easeInExpo</option>
									<option value="cubic-bezier(0.19, 1, 0.22, 1)">easeOutExpo</option>
									<option value="cubic-bezier(1, 0, 0, 1)">easeInOutExpo</option>
									<option value="cubic-bezier(0.6, 0.04, 0.98, 0.335)">easeInCirc</option>
									<option value="cubic-bezier(0.075, 0.82, 0.165, 1)">easeOutCirc</option>
									<option value="cubic-bezier(0.785, 0.135, 0.15, 0.86)">easeInOutCirc</option>
									<option value="cubic-bezier(0.6, -0.28, 0.735, 0.045)">easeInBack</option>
									<option value="cubic-bezier(0.175, 0.885, 0.32, 1.275)">easeOutBack</option>
									<option value="cubic-bezier(0.68, -0.55, 0.265, 1.55)">easeInOutBack</option>																						
								</select>
							</div>
						</div>
					</div>
					<div id="tab-options" class="edsai-tab-content edsai-options">
						<div class="edsai-form-control-wrapper">
							<label for="options-animation-repeat">Animation Repeat:</label>
							<div class="edsai-form-control">
								<select id="options-animation-repeat"
									name="options-animation-repeat" class="half-size has-custom">
									<option value="1">Once</option>
									<option value="2">Twice</option>
									<option value="3">Thrice</option>
									<option value="infinite">Infinite</option>
									<option value="custom">Custom</option>
								</select> <input id="options-animation-repeat-custom"
									name="options-animation-repeat-custom"
									class="half-size custom-field" placeholder="e.g. 4" />
							</div>
						</div>
						<div class="edsai-form-control-wrapper">
							<label for="options-keep">Keep Element Final State:</label>
							<div class="edsai-form-control">
								<input id="keep-yes" type="radio" name="options-keep"
									value="yes" checked> <label for="keep-yes">Yes</label> <input
									id="keep-no" type="radio" name="options-keep" value="no"> <label
									for="keep-no">No</label>
							</div>
						</div>
						<div class="edsai-form-control-wrapper">
							<label for="options-custom-css-class">Custom CSS Class:</label>
							<div class="edsai-form-control">
								<input id="options-custom-css-class"
									name="options-custom-css-class" class="half-size"
									placeholder="" value="" />
							</div>
						</div>
						<div class="edsai-form-control-wrapper">
							<label for="options-animate-on">Animate On:</label>
							<div class="edsai-form-control">
								<input type="radio" id="on-load" name="options-animate-on"
									value="load" checked> <label for="on-load">Load</label> <input
									type="radio" id="on-click" name="options-animate-on"
									value="click"> <label for="on-click">Click</label> <input
									type="radio" id="on-hover" name="options-animate-on"
									value="hover"> <label for="on-hover">Hover</label> <input
									type="radio" id="on-scroll" name="options-animate-on"
									value="scroll"> <label for="on-scroll">Scroll</label>
							</div>
						</div>
						<div
							class="edsai-form-control-wrapper options-scroll-settings-wrapper">
							<label for="options-scroll-offset">Scroll Offset (in %):</label>
							<div class="edsai-form-control">
								<input id="options-scroll-offset" name="options-scroll-offset"
									class="half-size" placeholder="Custom Offset % e.g. 20.7"
									value="<?php echo $scroll_offset; ?>" />
							</div>
						</div>						
					</div>
				</div>
				<div class="edsai-footer-wrapper">
					<div class="edsai-footer">
						<div class="edsai-footer-left">
							Powered by <a href="http://www.eleopard.in" target="_blank">eLEOPARD</a>
							| <a
								href="http://extensions.joomla.org/extensions/extension/style-a-design/design/animate-it"
								target="_blank">Review Plugin</a>
							| <a
								href="http://www.downloads.eleopard.in/animate-it-documentation"
								target="_blank">Documentation</a>
						</div>
						<div class="edsai-footer-right">
							<button type="button" class="btn-stop-infinite-animation"
								style="display: none;">Stop Animation</button>
							<button type="button" class="edsai-animate-it btn-animate-it">Animate
								It!</button>
							<button type="button" class="edsai-insert btn-insert" data-toggle="modal" data-target="#edsanimateModal">Insert</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script src="assets/jquery-1.12.0.min.js"></script>
	<script src="assets/animo.min.js"></script>	
	<script type="text/javascript">		
			( function( $ ) {
				
				var inAnimations = ["bounceIn","bounceInDown","bounceInLeft","bounceInRight",
			                    	"bounceInUp","fadeIn","fadeInDown","fadeInDownBig","fadeInLeft",
			                    	"fadeInLeftBig","fadeInRight","fadeInRightBig","fadeInUp","fadeInUpBig",
			                    	"rotateIn","rotateInDownLeft","rotateInDownRight","rotateInUpLeft",
			                    	"rotateInUpRight","slideInUp","slideInDown","slideInLeft","slideInRight",
			                    	"zoomIn","zoomInDown","zoomInLeft","zoomInRight","zoomInUp","flipInX",
			                    	"flipInY","lightSpeedIn","rollIn","twirlIn"];
            	
				$(document).ready( function() {					

					var animate_infinite = false;
					var total_repeat_count = 1;
					var element_animating = false;				

					$('.custom-field').hide();
					$('.options-scroll-settings-wrapper').hide();
					
					$('.edsai-tab-handler').on( 'click', function( event ) {
								
						event.preventDefault();
						
						var btn = $( this );
	
						$('.edsai-tab-content').css('display','none');
						$('.edsai-tab').removeClass('edsai-tab-active');
						
						btn.parent().addClass('edsai-tab-active');
						$( btn.attr('href') ).css('display','block');							
						
					} );			
	
					$('.has-custom').on( 'change', function( event ) {
	
						var select = $(this);
	
						if( 'custom' == select.val() ) {
							select.siblings('.custom-field').show();						
						} else {
							select.siblings('.custom-field').hide();
						}					
						
					} );	
	
					$('input[name="options-animate-on"]').on( 'change', function( event ) {
						
						var value = $('input[name="options-animate-on"]:checked').val();
	
						if( 'scroll' == value ) {
							$('.options-scroll-settings-wrapper').show();
						} else {
							$('.options-scroll-settings-wrapper').hide()
							$('input[name="options-scroll-offset"]').val('<?php echo $scroll_offset; ?>');
						}				
						
					} );

					$('#entry-animation-type').on( 'change', function( event ) {						
						var opt = $(this).val();
						$('#exit-animation-type option').attr("disabled", false);						
						$('#exit-animation-type option[value="'+opt+'"]').attr("disabled", true);
										
					} );

					$('#exit-animation-type').on( 'change', function( event ) {						
						var opt = $(this).val();
						$('#entry-animation-type option').attr("disabled", false);						
						$('#entry-animation-type option[value="'+opt+'"]').attr("disabled", true);
										
					} );
	
	
					function get_settings() {
	
						var settings = {
							'entry_animation_type': '',
							'entry_delay': '',
							'entry_duration': '',
							'entry_timing': '',
							'exit_animation_type': '',
							'exit_delay': '',
							'exit_duration': '',
							'exit_timing': '',
							'animation_repeat': '',
							'keep':'',
							'animate_on': '',
							'scroll_offset': '',							
							'custom_css_class': ''							
						};
	
						//reading entry animation settings
						var entry_animation_type = $('#entry-animation-type').val();					
						if( 'none' != entry_animation_type ){	
							settings.entry_animation_type = entry_animation_type;
											
							var entry_delay = $('#entry-delay').val();
							if( 'custom' == entry_delay ) {							
								var entry_delay = $('#entry-delay-custom').val();
								if( ! jQuery.isNumeric( entry_delay ) ) {
									entry_delay = 0;
								}							
							}	
							settings.entry_delay = entry_delay;	
														
							var entry_duration = $('#entry-duration').val();
							if( 'custom' == entry_duration ) {
								var entry_duration = $('#entry-duration-custom').val();							
								if( ! jQuery.isNumeric( entry_duration ) ) {
									entry_duration = 0.5;
								}
							}
							settings.entry_duration = entry_duration;	
							settings.entry_timing = $('#entry-timing').val();					
						}
	
						//reading exit animation settings
						var exit_animation_type = $('#exit-animation-type').val();
						if( 'none' != exit_animation_type ){
							
							settings.exit_animation_type = exit_animation_type;
										
							var exit_delay = $('#exit-delay').val();
							if( 'custom' == exit_delay ) {							
								var exit_delay = $('#exit-delay-custom').val();
								if( ! jQuery.isNumeric( exit_delay ) ) {
									exit_delay = 0;
								}													
							}	
							settings.exit_delay = exit_delay;
															
							var exit_duration = $('#exit-duration').val();
							if( 'custom' == exit_duration ) {
								var exit_duration = $('#exit-duration-custom').val();
								
								if( ! jQuery.isNumeric( exit_duration ) ) {
									exit_duration = 0.5;
								}							
							}	
							settings.exit_duration = exit_duration;				
							settings.exit_timing = $('#exit-timing').val();
						}
	
						//reading other options
						var animation_repeat = $('#options-animation-repeat').val();
						if( 'custom' == animation_repeat ) {
							var animation_repeat = $('#options-animation-repeat-custom').val();
							if( ! jQuery.isNumeric( animation_repeat ) ) {
								animation_repeat = 1;
							}
						}
						settings.animation_repeat = animation_repeat;				
	
						var animate_on = $('input[name="options-animate-on"]:checked').val();
						settings.animate_on = animate_on;		
									
						var scroll_offset = '';									
						if( 'scroll' == animate_on ) {
							scroll_offset = $('#options-scroll-offset').val();
							if( ! jQuery.isNumeric( scroll_offset ) ) {
								scroll_offset = '<?php echo $scroll_offset; ?>';
							}							
						}
						settings.scroll_offset = scroll_offset;						
						settings.custom_css_class = $('#options-custom-css-class').val();

						var keep_final_state = $('input[name="options-keep"]:checked').val();
						if( "yes" == keep_final_state ) {
							settings.keep = "yes";
						} else {
							settings.keep = "no";
						}
											
						return settings;
						
					}

					function reset_animation(){
						element_animating = false;
						animate_infinite = false;
						total_repeat_count = 1;
						$('.animateit-icon').animo("cleanse");														
						$('.btn-animate-it').show();
						$('.btn-stop-infinite-animation').hide();		
					}
								

					function eds_animate( animations, counter, iteration ) {
						
						$('.animateit-icon').animo( animations[ counter ].animoSettings, function() {
							counter++ 
							if( counter < animations.length ) {																												
								setTimeout( function(){ eds_animate( animations, counter, iteration ) }, Number(animations[counter].delay) * 1000);
							} else {							
								iteration++;
								if( true == animate_infinite || iteration < total_repeat_count) {			
									if(animations.length == 1) {
										$('.animateit-icon').animo("cleanse");
									}												
									setTimeout( function(){ eds_animate( animations, 0, iteration ) }, Number( animations[0].delay) * 1000);	
								} else {
									reset_animation();				
								}							
							}
							
						});
																
					}		
	
					$('.btn-insert').on( 'click', function( event ) {
						
						var settings = get_settings();						

						if( '' == settings.entry_animation_type 
								&& '' == settings.exit_animation_type ) {							
							alert("Please select animation first.");
							return '';
						}

						var	content = ' <p>Please add your content in this area.</p> ';
																		
						var hide_on_load_css_class = '';						
						
						if( 'scroll' == settings.animate_on || 'load' == settings.animate_on ) {
							hide_on_load_css_class	= ( inAnimations.indexOf( settings.entry_animation_type ) != -1 ) ? 'edsanimate-sis-hidden' : '';			
						}
						
						var codeBlcok = [ '{edsnewanimate|class="eds-animate ', hide_on_load_css_class, ' ', settings.custom_css_class, '"',
						                   '|data-eds-entry-animation="', settings.entry_animation_type, '"',
						                   '|data-eds-entry-delay="', settings.entry_delay, '"',
						                   '|data-eds-entry-duration="', settings.entry_duration, '"',
						                   '|data-eds-entry-timing="', settings.entry_timing, '"',
						                   '|data-eds-exit-animation="', settings.exit_animation_type, '"',
						                   '|data-eds-exit-delay="', settings.exit_delay, '"',
						                   '|data-eds-exit-duration="', settings.exit_duration, '"',
						                   '|data-eds-exit-timing="', settings.exit_timing, '"',
						                   '|data-eds-repeat-count="', settings.animation_repeat, '"',
						                   '|data-eds-keep="', settings.keep, '"',
						                   '|data-eds-animate-on="', settings.animate_on, '"',
						                   '|data-eds-scroll-offset="', settings.scroll_offset, '"', '}',
						                   content,
						                   '{/edsnewanimate}' ]. join('');

						window.parent.insertEdsAnimateTag( '<?php echo $ih_name; ?>', codeBlcok);
                        if(window.parent.SqueezeBox) {
                            window.parent.SqueezeBox.close();		
                        } else {
                            window.parent.Joomla.Modal.getCurrent().close();
                        }
					} );
	
					$('.btn-animate-it').on( 'click', function( event ) {
	
						var animations = [];
						
						var settings = get_settings();

						var keep_value = false;
						
						if("yes" == settings.keep ) {
							keep_value = true;
						}									
	
						if( '' != settings.entry_animation_type ) {

							animations.push({
								animoSettings: {
									animation:  settings.entry_animation_type,
									duration: settings.entry_duration,
									iterate: 1,
									timing: settings.entry_timing,
									keep: keep_value
								},
								delay: settings.entry_delay,
							});						
													
						}					
	
						if( '' != settings.exit_animation_type ) {
							animations.push({
								animoSettings: {
									animation:  settings.exit_animation_type,
									duration: settings.exit_duration,									
									iterate: 1,
									timing: settings.exit_timing,
									keep: keep_value
								},
								delay: settings.exit_delay
							});													
						}

						if( "infinite" == settings.animation_repeat ) {																		
							animate_infinite = true;																							
						} else {												
							animate_infinite = false;						
							total_repeat_count =  settings.animation_repeat;												
						}		

						if( animations.length >= 1 ) {	
							$('.btn-animate-it').hide();
							$('.btn-stop-infinite-animation').show();
							setTimeout( function(){ eds_animate( animations, 0, 0 )}, Number( animations[0].delay ) * 1000);								
						}						
						
					} );
	
					$('.btn-stop-infinite-animation').on( 'click', function( event ) {															
						reset_animation();											
					} );		

				} );		
				
			} )( jQuery );
					
		</script>
</body>
</html>
