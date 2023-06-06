jQuery(document).ready(function() {	
	jQuery(document).ready(function() {
		jQuery('.select-answer').on('click', function(){
			var id = jQuery(this).attr('data-id');
			jQuery( '#jform_answerid' ).val(id);
			jQuery("#setcorrectanswerform").submit();
		});
	});	
});