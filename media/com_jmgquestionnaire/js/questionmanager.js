jQuery(document).ready(function() {	
	jQuery(document).ready(function() {
		jQuery('.select-question').on('click', function(){
			var id = jQuery(this).attr('data-id');
			jQuery( '#jform_questionid' ).val(id);
			jQuery("#questioneditform").submit();
		});
		jQuery('.select-answer').on('click', function(){
			var id = jQuery(this).attr('data-id');
			jQuery( '#jform_answerid' ).val(id);
			jQuery("#setcorrectanswerform").submit();
		});
	});	
});

jQuery(document).ready(function($) {
   $('#question_modal').on('show.bs.modal', function() {
	   //alert('test');
      // $('body').addClass('modal-open');
       //var modalBody = $(this).find('.modal-body');
      // modalBody.find('iframe').remove();
       //modalBody.prepend('<iframe class="iframe jviewport-height70" src="index.php?option=com_jmgquestionnaire&amp;view=question&amp;layout=modal&amp;tmpl=component&amp;id=' + 2 + '" name="Frage bearbeiten" height="400px" width="800px"></iframe>');
   }).on('shown.bs.modal', function() {

   }).on('hide.bs.modal', function () {
       //$('body').removeClass('modal-open');
       //$('.modal-body').css({'max-height': 'initial', 'overflow-y': 'initial'});
      // $('.modalTooltip').tooltip('destroy');
	   questionsrefresh();
   });
});