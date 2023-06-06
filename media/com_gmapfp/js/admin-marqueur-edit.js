/**
* PLEASE DO NOT MODIFY THIS FILE. WORK ON THE ES6 VERSION.
* OTHERWISE YOUR CHANGES WILL BE REPLACED ON THE NEXT BUILD.
**/

/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * version : J4_1F
 * Creation date: Avril 2021
 */
 
var markerUrl	= ""
var markerImage = new Image();
var shadowUrl	= ""
var shadowImage = new Image();

Joomla.submitbutton = function(task) {
	var form = document.adminForm;
	if (task == 'marqueur.cancel') {
		Joomla.submitform(task, document.adminForm);
		return;
	}
	if (document.formvalidator.isValid(document.adminForm)) {
		//detecte la taille du marqueur
		document.getElementById("jform_marker_height").value = markerImage.height;
		document.getElementById("jform_marker_width").value = markerImage.width;
		//renseigne les valeurs de centrage du marqueur : iconAnchor
		var centre_x = document.getElementById("jform_centre_x");
		if (centre_x.selectedIndex == ""){
			centre_x.selectedIndex = parseInt(markerImage.width/2);
		}
		var centre_y = document.getElementById("jform_centre_y");
		if (centre_y.selectedIndex == ""){
			centre_y.selectedIndex = markerImage.width;
		}
		//detecte la taille de l'ombre
		document.getElementById("jform_shadow_height").value = shadowImage.height;
		document.getElementById("jform_shadow_width").value = shadowImage.width;

		Joomla.submitform(task, document.adminForm);
	}
}

function RafraichirMarqueur() {
	if(jQuery("#jform_url_type").val() == 1) {
		markerUrl = document.getElementById("jform_url_interne").value;
		markerImage.src = '../' + markerUrl;
	} else {
		markerUrl = document.getElementById("jform_url_externe").value;
		markerImage.src = markerUrl;
	}
	document.getElementById("image_marqueur").src = markerImage.src;
	document.getElementById("jform_url").value = markerUrl;
	setTimeout(EnableValue, 500);
	document.getElementById("pos_centre_img").style.left = (75 - document.getElementById("jform_centre_x").value) + 'px';
	document.getElementById("pos_centre_img").style.top = (44 - document.getElementById("jform_centre_y").value) + 'px';
		
}

function RafraichirOmbre(){
  document.getElementById("image_ombre").src = document.getElementById("jform_url_shadow").value;
  shadowImage.src = shadow.value;
}

function RafraichirCentre_x(){
  document.getElementById("pos_centre_img").style.left = (75 - document.getElementById("jform_centre_x").value) + 'px';
  document.getElementById("pos_centre_ombre").style.left = (75 - document.getElementById("jform_centre_x").value) + 'px';
}

function RafraichirCentre_y(){
  document.getElementById("pos_centre_img").style.top = (44 - document.getElementById("jform_centre_y").value) + 'px';
  document.getElementById("pos_centre_ombre").style.top = (44 - document.getElementById("jform_centre_y").value) + 'px';
}

function init(){
		setInterval(RafraichirMarqueur, 1000);
 }

function EnableValue(){
  document.getElementById("jform_marker_height").value = markerImage.height;
  document.getElementById("jform_marker_width").value = markerImage.width;
 }

jQuery(document).ready( function(){ init();});
