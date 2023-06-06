jQuery(document).ready(function() {	
	jQuery(document).ready(function() {
		jQuery('.back').on('click', function(){
			var step = jQuery( '#nextstep' ).val();
			jQuery( '#nextstep' ).val(step - 2);
			jQuery("#multistepform").submit();
		});
	});	
});