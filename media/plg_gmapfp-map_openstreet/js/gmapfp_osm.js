	/*
	* GMapFP Component Google Map for Joomla! 4.x
	* Version J4_6F
	* Creation date: Juillet 2022
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

var marker = {};
var map_marker = {};
var arrayOfLatLngs = [];

var params_map = null;

 (function (document, Joomla, $) {
  'use strict';

	$.show_map_infos = function(map, num) {
		marker 			= eval('marker' + num);
		map_marker 		= eval('map_marker' + num);
		arrayOfLatLngs 	= eval('arrayOfLatLngs' + num);
		params_map 		= eval ('map_params' + num + ';');
		var val1, val2;

		//creer la liste des marqueurs
		var marqueurs = eval ('marqueurs_datas' + num + ';');
		$.each(marqueurs, function(i, obj){
			if (obj.url) {
				val1 = obj.url.substr(0, 4);
				val2 = obj.url.substr(0, 2);
				if(val1 != 'http' && val2 != '//')
					obj.url = GMapFP_baseURL + obj.url;
			}
			if (obj.url_shadow) {
				val1 = obj.url_shadow.substr(0, 4);
				val2 = obj.url_shadow.substr(0, 2);
				if(val1 != 'http' && val2 != '//')
					obj.url_shadow = GMapFP_baseURL + obj.url_shadow;
			}
			marker[obj.id] = L.icon({
				iconUrl: obj.url,
				iconSize: [obj.marker_width, obj.marker_height],
				iconAnchor: [obj.centre_x, obj.centre_y],
				popupAnchor: [0, -obj.centre_y],
				shadowUrl: obj.url_shadow,
				shadowSize: [obj.shadow_width, obj.shadow_height]
			});
		});
		
		//creer les marqueurs
		var datas = eval ('map_datas' + num + ';');
		$.each(datas, function(i, obj){
			if(marker[obj.marqueur]!= undefined) {
				var options = {
					icon: marker[obj.marqueur], 
					draggable: false, 
					item_id: obj.id,
					item_link: obj.link,
					item_article_id: obj.article_id,
					item_icon: obj.icon
				};
			} else {
				var options = {
					draggable: false, 
					item_id: obj.id,
					item_link: obj.link,
					item_article_id: obj.article_id,
					item_icon: obj.icon
				};
			}
			if (obj.marqueur) { // si pas de marqueur défini, affiche celui par défaut
				map_marker[obj.id] = L.marker([obj.glat, obj.glng], options).bindPopup(make_bubble(obj), {maxWidth: params_map.gmapfp_width_bulle_GMapFP}).addTo(map);
			} else {
				map_marker[obj.id] = L.marker([obj.glat, obj.glng], options).bindPopup(make_bubble(obj), {maxWidth: params_map.gmapfp_width_bulle_GMapFP}).addTo(map);
			}
			arrayOfLatLngs.push([obj.glat, obj.glng]);
			//gestion de l'animation de la bubble
			if (params_map.gmapfp_eventcontrol >= 1) map_marker[obj.id].on('mouseover', function (e) {this.openPopup();});
			if (params_map.gmapfp_eventcontrol == 1) map_marker[obj.id].on('mouseout', function (e) {this.closePopup();});
			//gestion de l'affichage du lien du marqueur
			if (params_map.gmapfp_plus_detail == 1 && params_map.gmapfp_eventcontrol >= 1 && params_map.target != 4) map_marker[obj.id].on('click', show_marker_link);
		});
		
		function make_bubble(obj) {
			let image = {};
			let gmapfp_img_style = '';
			if (obj.img) image = JSON.parse(obj.img);
			if (!image || !image.image) {
				image.image = "";
				gmapfp_img_style = 'style="display:none;"';
			}
			return eval(eval('bubble_datas' + num));
		}
	
	} 	  
})(document, Joomla, jQuery);

function over_marker(id) {
	if (params_map.gmapfp_eventcontrol >= 1) map_marker[id].openPopup();
}

function out_marker(id) {
	if (params_map.gmapfp_eventcontrol == 1) map_marker[id].closePopup();
}

