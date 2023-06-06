	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_2F
	* Creation date: Juillet 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

function UpdateAddress(){
	jQuery("#localisation").val(jQuery("#jform_adresse").val() + " " + jQuery("#jform_adresse2").val() + " " + jQuery("#jform_codepostal").val() + " " + jQuery("#jform_ville").val() + " " + jQuery("#jform_departement").val() + ", " + jQuery("#jform_pays").val());
}

function IsReal(e){
	MonNombre=jQuery("#"+e.id).val();
	if(isNaN(MonNombre))
	{
		alert( MonNombre + joomla.jtext('COM_GMAPFP_PAS_NBRE_REEL'));
		return false;
	}
	return true;
}

function showAddress() {
	
	var add1 = jQuery('#jform_adresse').val();
	var add2 = jQuery('#jform_adresse2').val();
	var cp = jQuery('#jform_codepostal').val();
	var ville = jQuery('#jform_ville').val();
	var departement = jQuery('#jform_departement').val();
	var pays = jQuery('#jform_pays').val();

	jQuery.ajax({
		url: '../index.php?option=com_gmapfp&task=Ajax.getlatlng',
		data: {
			add1 : add1,
			add2 : add2,
			cp : cp,
			ville : ville,
			departement : departement,
			pays : pays
		}
	}).done(function(response) {
		// console.log(response);
		var obj = JSON.parse(response);
		if (obj.success) {
			if (obj.data.error) {
				Joomla.renderMessages({"error":[obj.data.error]});
			} else {
				setCoordinate(obj.data.lat, obj.data.lng);
				jQuery("#jform_glat").val(obj.data.lat);
				jQuery("#jform_glng").val(obj.data.lng);			
			};
		} else {
			Joomla.renderMessages({"error":[obj.message]});
		};		
	});
	return false;
}

