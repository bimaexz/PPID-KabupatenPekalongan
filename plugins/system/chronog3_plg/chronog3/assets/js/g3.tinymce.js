(function($){
	$.G3.tinymce = {};
	
	$.G3.tinymce.remove = function(selector){
		if(selector == undefined){
			selector = 'textarea[data-editor="1"]';
		}
		tinymce.remove(selector);
	}
	
	$.G3.tinymce.init = function(selector){
		$.G3.tinymce.remove();
		
		if(selector == undefined){
			selector = 'textarea[data-editor="1"]';
		}
		
		$(selector).each(function(i, textarea){
			var tinymceSettings = {
				//selector: $(textarea),
				//target: textarea,
				width: '100%',
				height: 200,
				//theme: 'modern',
				plugins: [
				'autolink lists link image charmap print preview hr anchor pagebreak',
				'searchreplace wordcount visualblocks visualchars code fullscreen',
				'media save table directionality',
				'emoticons template paste textcolor colorpicker textpattern imagetools codesample'
				],
				toolbar1: $(textarea).data('toolbar1') ? $(textarea).data('toolbar1') : 'code visualblocks | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify',
				toolbar2: $(textarea).data('toolbar2') ? $(textarea).data('toolbar2') : 'bullist numlist outdent indent | link image media | forecolor backcolor | hr | removeformat | preview',
				toolbar3: $(textarea).data('toolbar3') ? $(textarea).data('toolbar3') : '',
				image_advtab: true,
				visualblocks_default_state: true,
				menu : {},
				relative_urls: false,
				//document_base_url : "http://www.example.com/path1/",
				remove_script_host: false,
				convert_urls: false,
				//link_context_toolbar: true,
				//link_assume_external_targets: true,
				protect: [
					/\<\/?(if|endif)\>/g,  // Protect <if> & </endif>
					/<\?php.*?\?>/g  // Protect php code
				],
				content_css: [
					//'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
					//'//www.tinymce.com/css/codepen.min.css'
				]
				
			};

			tinymceSettings['target'] = textarea;
			
			if($(textarea).data('eheight')){
				tinymceSettings['height'] = $(textarea).data('eheight');
			}
			if($(textarea).data('ewidth')){
				tinymceSettings['width'] = $(textarea).data('ewidth');
			}
			
			tinymce.init(tinymceSettings);
		});
	};
	
}(jQuery));