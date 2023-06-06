/*********************************************************/
/* Gestion des cookies                                   */
/*********************************************************/
function gmapfp_createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function gmapfp_readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function gmapfp_eraseCookie(name) {
	gmapfp_createCookie(name,"",-1);
}

/*********************************************************/
/* position html5                                        */
/*********************************************************/
var gmapfp_geolocalisation_ok = false;
var gmapfp_maposition_lat = null;
var gmapfp_maposition_lng = null;
function displayGeolocalisation(map_num) {
	active_map = map_num;
	if (navigator.geolocation) {
		navigator.geolocation.watchPosition(positionSuccess, positionError);
	} else {
		positionError(-1);
	}
}

function positionError(err) {
	var msg;
	switch(err.code) {
	  case err.UNKNOWN_ERROR:
		msg = Joomla.JText._('COM_GMAPFP_MAP_LOCATION_ERROR_UNKNOWN_ERROR');
		break;
	  case err.PERMISSION_DENINED:
		msg = Joomla.JText._('COM_GMAPFP_MAP_LOCATION_ERROR_PERMISSION_DENINED');
		break;
	  case err.POSITION_UNAVAILABLE:
		msg = Joomla.JText._('COM_GMAPFP_MAP_LOCATION_ERROR_POSITION_UNAVAILABLE');
		break;
	  case err.BREAK:
		msg = Joomla.JText._('COM_GMAPFP_MAP_LOCATION_ERROR_BREAK');
		break;
	  default:
		msg = Joomla.JText._('COM_GMAPFP_MAP_LOCATION_ERROR_DEFAULT');
	}
	for (i = 0; i <= GMapFP_num.length - 1; i++) {
		document.getElementById('info_geolocalisation' + GMapFP_num).innerHTML = msg;
	}
}

function contains(array, item) {
  for (var i = 0, I = array.length; i < I; ++i) {
	  if (array[i] == item) return true;
	}
	return false;
}

/*********************************************************/
/* Goto place                                            */
/*********************************************************/
var come_back_goto_place = [];

function goto_place(map_num, glat, glng, place_id) {
	if (gmapfp_geolocalisation_ok) {
		come_back_goto_place = [];
		jQuery('#select_from' + map_num + ' option:eq(1)').prop('selected', true);
		jQuery('#select_to' + map_num + ' option[value="' + glat + ',' + glng + ',' + place_id + '"]').prop('selected', true);
		eval('OnSubmit_Itin(' + map_num + ')');
	} else {
		come_back_goto_place = [map_num, glat, glng, place_id];
		displayGeolocalisation(map_num);
		// alert(Joomla.JText._('COM_GMAPFP_ERROR_YOUR_PLACE_NOT_LOCALIZED'));
	}
}

function get_new_place(select_zone, text_zone) {
	jQuery('#' + select_zone).parent().toggle(500);
	jQuery('#' + text_zone).parent().toggle(500);
}

/*********************************************************/
/* Calcul l'itinéraire                                   */
/*********************************************************/
function OnSubmit_Itin(num_map) {
	CalculRoute(num_map);
	Show_bp_print(num_map);
}
function onchange_travel_mode(modeselected, map_num) {
	switch (modeselected) {
	case "bike": 
		mode = 'BICYCLING';
		gmapfp_createCookie('gmapfp_itin_travelMode', 'BICYCLING', 1);
		jQuery("[class^='map-bike-button-']").addClass('selected');
		jQuery("[class^='map-walk-button-']").removeClass('selected');
		jQuery("[class^='map-transit-button-']").removeClass('selected');
		jQuery("[class^='map-car-button-']").removeClass('selected');
		break;
	case "walk": 
		mode = 'WALKING';
		gmapfp_createCookie('gmapfp_itin_travelMode', 'WALKING', 1);
		jQuery("[class^='map-bike-button-']").removeClass('selected');
		jQuery("[class^='map-walk-button-']").addClass('selected');
		jQuery("[class^='map-transit-button-']").removeClass('selected');
		jQuery("[class^='map-car-button-']").removeClass('selected');
		break;
	case "transit": 
		mode = 'TRANSIT';
		gmapfp_createCookie('gmapfp_itin_travelMode', 'TRANSIT', 1);
		jQuery("[class^='map-bike-button-']").removeClass('selected');
		jQuery("[class^='map-walk-button-']").removeClass('selected');
		jQuery("[class^='map-transit-button-']").addClass('selected');
		jQuery("[class^='map-car-button-']").removeClass('selected');
		break;
	default: 
		mode = 'DRIVING';
		gmapfp_createCookie('gmapfp_itin_travelMode', 'DRIVING', 1);
		jQuery("[class^='map-bike-button-']").removeClass('selected');
		jQuery("[class^='map-walk-button-']").removeClass('selected');
		jQuery("[class^='map-transit-button-']").removeClass('selected');
		jQuery("[class^='map-car-button-']").addClass('selected');
	}
	eval('travel_mode' + map_num + ' = mode;');
}

/*********************************************************/
/* Affiche de l'affichage de zones "select"              */
/*********************************************************/

//rafraichi les données d'itinéraire
function DisplayDirectionData(map_num){
	let directions = [];
	eval('datas_direction = map_datas' + map_num + ';');
	eval('jQuery("#select_from'+map_num+' option").remove();');
	eval('jQuery("#select_to'+map_num+' option").remove();');
	jQuery("<option />", { val: '', text: Joomla.JText._('COM_GMAPFP_MAP_SELECT') }).appendTo(jQuery("#select_from"+map_num));
	jQuery("<option />", { val: '', text: Joomla.JText._('COM_GMAPFP_MAP_SELECT') }).appendTo(jQuery("#select_to"+map_num));
	jQuery.each(datas_direction, function(index, value){
		// Create option
		directions.push({'title' : value['title'], 'data' : (value['glat']+','+value['glng']+','+value['id'])});
	});
	
	//trie par ordre alpha
	Array.prototype.sortOn = function(key){
		this.sort(function(a, b){
			if(a[key] < b[key]){
				return -1;
			}else if(a[key] > b[key]){
				return 1;
			}
			return 0;
		});
	}
	directions.sortOn('title');
	
	jQuery.each(directions, function(index, value){
		// Create option
		jQuery("<option />", { val: value['data'], text: value['title'] }).appendTo(jQuery("#select_from"+map_num));
		jQuery("<option />", { val: value['data'], text: value['title'] }).appendTo(jQuery("#select_to"+map_num));
	});
}

function Show_bp_print(map_num) {
	var ok = false;
	if (document.getElementById("select_from"+map_num).selectedIndex!=0 && (document.getElementById("select_to"+map_num).selectedIndex!=0 || document.getElementById("text_to"+map_num).value!="")) {
		ok = true;
	} else if (document.getElementById("select_to"+map_num).selectedIndex!=0 && document.getElementById("text_from"+map_num).value!="") {
			ok = true;
	}
/*	if (ok) {
		jQuery("#bp_print_itin"+map_num).css("display", "block");
		eval("directionsDisplay"+map_num+".setMap(carteGMapFP"+map_num+");");
	} else {
		jQuery("#bp_print_itin"+map_num).css("display", "none");
		jQuery("#gmapfp_directions"+map_num).text("");
		eval("directionsDisplay"+map_num+".setMap(null);");
	}*/
}

//active ou desactive les éléments de selection en attendant le rafraichissement des données
function GMapFP_disable_filter (value, map_num) {
	eval('tmp = typeof(gmapfp_filtres'+map_num+');');
	eval(' if (tmp != \'undefined\') for(var i = 0; i < gmapfp_filtres'+map_num+'.length; i++) { if (document.getElementById(gmapfp_filtres'+map_num+'[i])) document.getElementById(gmapfp_filtres'+map_num+'[i]).disabled = value;};');
	jQuery("#filtre_search").attr('disabled', value);
	jQuery("#filtre_reset_search").attr('disabled', value);
	jQuery("#search_gmapfp").attr('disabled', value);
	jQuery(".gmapfp_cat_sel input").attr('disabled', value);
	eval('jQuery("form[name=direction_form'+map_num+'] input").attr("disabled", '+value+');');
	eval('jQuery("form[name=direction_form'+map_num+'] select").attr("disabled", '+value+');');
}

function update_info(map_num) {
	DisplayDirectionData(map_num);
	GMapFP_disable_filter (false, map_num)
}

function show_marker_link (id, num) {

	var map_link = '';
	var options = '';

	if (typeof id == 'object') {
		options = this.options;
		id = options.item_id;
	} else {
		if(num) eval('map_marker = map_marker' + num + ';');
		options = map_marker[id].options;
	}
	map_link = options.item_link;
	
	switch (params_map.target) {
		case '1': // open in parent avec navigation
			parent.location = map_link;
			break;
		case '2': // open in nouvelle fenêtre avec barre de navigation
			window.open(map_link, 'info' + id, 'toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width="' + params_map.gmapfp_largeur_lightbox + '",height="' + params_map.gmapfp_hauteur_lightbox + '"');
			break;
		case '3': // open in a popup window
			window.open(map_link+'&tmpl=component', 'info' + id, 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width="' + params_map.gmapfp_largeur_lightbox + '",height="' + params_map.gmapfp_hauteur_lightbox + '"');
			break;
		default: // open in lightbox joomla
			jQuery.fancybox.open({type: 'iframe', iframe: {css: {width: params_map.gmapfp_largeur_lightbox, height: params_map.gmapfp_hauteur_lightbox, padding: '10px !important' }}, src: map_link+'&tmpl=component'});
	}
}

