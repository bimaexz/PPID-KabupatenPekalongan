(function($){
	$.G3.signature_pad = {};
	$.G3.signature_pad.ready = function(){
		$("canvas[data-signature]").each(function(pi, pad){
			var wrapper = $(pad).closest(".field"),
				clearButton = wrapper.find("[data-action=clear]"),
				saveButton = wrapper.find("[data-action=save]"),
				canvas = wrapper.find("canvas").get(0),
				signaturePad;
			
			function resizeCanvas() {
				//var ratio =  Math.max(window.devicePixelRatio || 1, 1);
				
				var parentWidth = $(canvas).parent().width();
				if(parentWidth){
					canvas.width = $(canvas).parent().width();
				}
				//canvas.width = canvas.offsetWidth * ratio;
				//canvas.height = canvas.offsetHeight * ratio;
				//canvas.getContext("2d").scale(ratio, ratio);
				canvas.getContext("2d").scale(1, 1);
			}
			
			window.onresize = resizeCanvas;
			resizeCanvas();
			
			signaturePad = new SignaturePad(canvas, {
				"onEnd": function(){
					wrapper.find("input[type=hidden]").val(signaturePad.toDataURL());
				},
			});
			
			clearButton.on("click", function (event) {
				signaturePad.clear();
				wrapper.find("input[type=hidden]").val('');
			});
			
			if(wrapper.find("input[type=hidden]").length){
				signaturePad.fromDataURL(wrapper.find("input[type=hidden]").val());

				wrapper.find("input[type=hidden]").on('change.reset', function(){
					if($(this).val()){
						signaturePad.fromDataURL($(this).val());
					}else{
						signaturePad.clear();
					}
				});
			}
		});
	};
}(jQuery));