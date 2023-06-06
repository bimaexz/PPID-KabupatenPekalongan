	/*
	* GMapFP Component Google Map for Joomla! 4.0.x
	* Version J4_2F
	* Creation date: Juillet 2021
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: support@gmapfp.org
	* License GNU/GPL
	*/

function get_gmapfp_news() {
 	jQuery.ajax({
		url: '../index.php?option=com_gmapfp&task=Ajax.getnews',
	}).done(function(response) {
		jQuery('#gmapfp_news').html(response);
	}).fail(function() {
		jQuery('#gmapfp_news').html(Joomla.JText._('GMAPFP_ERROR_UPDATE_NEWS'));
	});
}

jQuery(document).ready(function(){
	get_gmapfp_news();
});