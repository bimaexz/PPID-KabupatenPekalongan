	/*
	* GMapFP Plugin Google Map for GMapFP 4.x
	* Version J4_5F
	* Creation date: Juillet 2022
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/
 
var marker = {};
var map_marker = {};
var infowindow = {};
var arrayOfLatLngs = [];

var params_map = null;

(function (document, Joomla, $) {
  'use strict';

	$.show_map_infos = function(map, bounds, num) {
		marker 			= eval('marker' + num);
		map_marker 		= eval('map_marker' + num);
		infowindow 		= eval('infowindow' + num);
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
			var image_marker = new google.maps.MarkerImage(
				obj.url,
				new google.maps.Size(obj.marker_width, obj.marker_height),
				new google.maps.Point(0,0),
				new google.maps.Point(obj.centre_x, obj.centre_y)
			);
			var shadow_marker = new google.maps.MarkerImage(
				obj.url_shadow,
				new google.maps.Size(obj.shadow_width, obj.shadow_height),
				new google.maps.Point(0,0),
				new google.maps.Point(obj.centre_x, obj.centre_y)
			);
			var shape_marker = {
				coord: [0, 0, obj.marker_width, obj.marker_height],
				// type: \'rect\'
			};

			marker[obj.id] = new Object({
				icon: image_marker,
				shadow: shadow_marker,
				shape: shape_marker,
			});
		});
		
		//creer les marqueurs
		var datas = eval ('map_datas' + num + ';');
		$.each(datas, function(i, obj){
			var maLatLng = new google.maps.LatLng(obj.glat, obj.glng);
			if(marker[obj.marqueur]!= undefined) {
				map_marker[obj.id] = new google.maps.Marker({
					icon: marker[obj.marqueur].icon,
					shadow: marker[obj.marqueur].shadow,
					// shape: marker[obj.marqueur].shape,
				});
			} else {
				map_marker[obj.id] = new google.maps.Marker({
				});
			}
			map_marker[obj.id].setPosition(maLatLng);
			map_marker[obj.id].setZIndex(obj.id);
			map_marker[obj.id].setMap(map);
			map_marker[obj.id].catid = obj.catid;
			
			//centrage auto
			bounds.extend(maLatLng);
			
			var options = {
				item_id: obj.id,
				item_link: obj.link,
				item_article_id: obj.article_id,
				item_icon: obj.icon
			};
			map_marker[obj.id].options = options;
			
			//gestion de l'animation de la bubble
			infowindow[obj.id] = new google.maps.InfoWindow({
				content: make_bubble(obj),
				maxWidth: params_map.gmapfp_width_bulle_GMapFP
			});			
			if (params_map.gmapfp_eventcontrol >= 1) 
				map_marker[obj.id].addListener('mouseover', () => {
					infowindow[obj.id].open(map, map_marker[obj.id]);
				});
			if (params_map.gmapfp_eventcontrol == 1) 
				map_marker[obj.id].addListener('mouseout', () => {
					infowindow[obj.id].close(map, map_marker[obj.id]);
				});
			//gestion de l'affichage du lien du marqueur
			if (params_map.gmapfp_plus_detail == 1 && params_map.gmapfp_eventcontrol >= 1 && params_map.target != 4) 
				map_marker[obj.id].addListener('click', () => {
					infowindow[obj.id].close(map, show_marker_link(obj.id, num));
				});
		});
		
		function make_bubble(obj) {
			let image = {};
			let gmapfp_img_style = '';
			if (obj.img) {
				// console.log(obj.img);
				image = JSON.parse(obj.img);
				// console.log(image);
			}
			if (!image || !image.image) {
				image.image = "";
				gmapfp_img_style = 'style="display:none;"';
			}
			return eval(eval('bubble_datas' + num));
		}
	}
  	  
})(document, Joomla, jQuery);

function over_marker(id) {
	if (params_map.gmapfp_eventcontrol >= 1) infowindow[id].open(map, map_marker[id]);
}

function out_marker(id) {
	if (params_map.gmapfp_eventcontrol == 1) infowindow[id].close();
}
