<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	\GApp3::document()->_('jquery-ui');
	\GApp3::document()->__('keepalive');
	\GApp3::document()->_('tinymce');
	\GApp3::document()->_('ace');
?>
<style>
<?php
	ob_start();
?>
a.ui.label:hover{color:navy;}
body > .item.draggable svg.icon{height: 45% !important;}
/* .draggable-receiver{border:2px solid green !important;} */
.active_droppable{border:2px solid red !important;}
/* .draggable{cursor:move;} */
.draggable-receiver-title{cursor:pinter;}
.ui.message.unit-config{padding:10px !important;}

.ui.segment.active.functions-tab{background-color:#f2f2f2;}
.ui.segment.active.views-tab{background-color:#f2f2f2;}

.mce-tinymce-inline.mce-floatpanel{display:none !important;}

.dragged_actions{float:right;}

.active_sortable{max-width:150px;}
.active_sortable .ui.fluid{display:none;}

.accordion1::-webkit-scrollbar { /* WebKit */
	width: 0;
	height: 0;
}
.accordion1 {
	overflow-y: scroll;
	overflow-x: hidden;
	scrollbar-width: thin; /* Firefox */
	-ms-overflow-style: none;  /* Internet Explorer 10+ */
}
<?php if($utype != 'functions' AND $this->data('Connection.apptype') != 'connectivity'): ?>
	.dragged_name{
		display:none;
	}
<?php endif; ?>
<?php
	$csscode = ob_get_clean();
	\GApp3::document()->addCssCode($csscode);
?>
</style>
<script>
<?php
	ob_start();
?>
	//jQuery('form').addClass('loading');
	jQuery(document).ready(function($) {
		$('body').on('dragndrop.make.draggable', '.draggable', function(e){
			$(this).draggable({
				'helper' : 'clone',
				appendTo: 'body',
				//'revert' : 'invalid',
				connectToSortable: '.draggable-receiver:not(.drop_disabled)',
				start: function(e, ui){
					$(ui.helper).find('.button').css('z-index', 999999);
					$(ui.helper).find('.button').css('min-width', '200px');
					$(ui.helper).find('.button').addClass('ui button orange quti bg-grey700 text-white');
				}
			});
		});
		$('body').find('.draggable').trigger('dragndrop.make.draggable');
		
		$('body').on('dragndrop.make.droppable', '.draggable-receiver', initDroppable);
		$('body').find('.draggable-receiver').trigger('dragndrop.make.droppable');
		
		$('body').on('calculate', '.draggable-receiver', function(e){
			e.stopPropagation();
			$(this).prev('.draggable-receiver-title').find('.dragged_count').html($(this).children().length);
		});
		$('.draggable-receiver').trigger('calculate');

		// $('[data-receive="functions"]').addClass('disabled');

		$('body').on('click', '[data-receive]', function(e){
			if($(this).data('receive') == 'views'){
				$('[data-receive="functions"]').addClass('drop_disabled');
				$('[data-receive="views"]').removeClass('drop_disabled');

				$('[data-tab="views-list"]').addClass('active');
				$('[data-tab="functions-list"]').removeClass('active');

				$('[data-receive="views"]').children('.ui.dimmer').removeClass('active');
				$('[data-receive="functions"]').children('.ui.dimmer').addClass('active');

				$('[data-receive="views"]').css('z-index', '');
				$('[data-receive="functions"]').css('z-index', '5');

				$('.dropdown.item[data-utype="functions"]').addClass('hidden');
				$('.dropdown.item[data-utype="views"]').removeClass('hidden');

				$('.menu_header.item[data-utype="functions"]').addClass('hidden');
				$('.menu_header.item[data-utype="views"]').removeClass('hidden');
				
				$('.dropdown.item[data-utype="views"]').first().closest('.ui.menu').addClass('teal').removeClass('purple');
			}else{
				$('[data-receive="views"]').addClass('drop_disabled');
				$('[data-receive="functions"]').removeClass('drop_disabled');

				$('[data-tab="views-list"]').removeClass('active');
				$('[data-tab="functions-list"]').addClass('active');

				$('[data-receive="views"]').children('.ui.dimmer').addClass('active');
				$('[data-receive="functions"]').children('.ui.dimmer').removeClass('active');

				$('[data-receive="views"]').css('z-index', '5');
				$('[data-receive="functions"]').css('z-index', '');

				$('.dropdown.item[data-utype="functions"]').removeClass('hidden');
				$('.dropdown.item[data-utype="views"]').addClass('hidden');

				$('.menu_header.item[data-utype="views"]').addClass('hidden');
				$('.menu_header.item[data-utype="functions"]').removeClass('hidden');

				$('.dropdown.item[data-utype="views"]').first().closest('.ui.menu').addClass('purple').removeClass('teal');
			}
		});
		
		//apply the auto name from label
		$('body').on('keyup change', '.field_label', function(){
			var label = this;
			if($(label).val()){
				var config = $(this).closest('.config_area');
				config.find('.field_param_name, .field_param_id').each(function(iinp, inpauto){
					if($(inpauto).closest('.field').find('.field_param_name_auto').first().prop('checked')){
						$(inpauto).val($(label).val().toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'_').replace(/_+$/g, ''));
					}
				});

				$(this).closest('.dragged').find('.unit-title').first().find('.detail').first().text($(this).val());
				$(this).closest('.dragged').data('title', $(this).val());

				updateLists(false, 'inputs');
			}
		});
		//fix name/ids spaces
		$('body').on('keyup change', '.field_param_name, .field_param_id', function(){
			$(this).val($(this).val().replace(/[^\w \.\#\-]+/g,'').replace(/ +/g,'_'));
		});
		//fix name/ids spaces
		$('body').on('keyup change', '.pagename', function(){
			$(this).val($(this).val().replace(/[^\w\- ]+/g,'').replace(/ +/g,'_'));
			$(this).closest('.pagesList').find('.ui.header').first().html($(this).val());
			$(this).closest('.pagesList').attr('data-name', $(this).val());
			$(this).closest('.pagesList').attr('data-title', $(this).closest('.pgroup').attr('data-title')+'.'+$(this).val());
		});
		$('body').on('keyup change', '.pgroupname', function(){
			$(this).val($(this).val().replace(/[^\w\. ]+/g,'').replace(/ +/g,'_'));
			$(this).closest('.pgroup').find('.ui.header').first().html($(this).val());
			$(this).closest('.pgroup').attr('data-title', $(this).val());
			var pgroup = $(this).closest('.pgroup');
			$(this).closest('.pgroup').find('.pagesList').each(function(Pi, Page){
				$(Page).attr('data-title', pgroup.attr('data-title')+'.'+$(Page).attr('data-name'));
			});
		});

		//apply icon preview
		$('body').on('input', '[data-iconpreview]', function(){
			$(this).next('i').attr('class', $(this).val() + ' icon');
		});
		$('[data-iconpreview]').trigger('input');
		
		$('body').on('click', '.edit_dragged', function(){
			var element = $(this);
			//removed transition because of the ace editor
			if(element.hasClass('safe_mode')){
				element.addClass('loading');

				$.ajax({
					url: element.closest('.dragged').data('url'),
					//data: element.closest('.dragged').find(':input').serialize(),
					type: 'POST',
					success: function(result){
						var newFunc2 = $(result);
						
						element.closest('.dragged').find('.config_area').first().replaceWith(newFunc2);
						
						// $(newFunc2).find('.draggable-receiver').trigger('dragndrop.make.droppable');
						
						newFunc2.trigger('contentChange.basics', {'act':'cfw_unit_added'});

						// newFunc2.find('.edit_dragged').first().trigger('click');
						element.closest('.dragged_actions').find('.safe_mode').removeClass('safe_mode loading');
						element.closest('.dragged').find('.config_area').first().toggleClass('hidden visible');
					}
				});
			}else{
				element.closest('.dragged').find('.config_area').first().toggleClass('hidden visible');//transition('slide down');
			}
			
		});
		
		$('body').on('mouseover', '.dragged', function(e){
			e.stopPropagation();
			$(this).children('.dragged_actions').children('.dragged_action.hidden').removeClass('hidden');
		}).on('mouseout', '.dragged', function(){
			$(this).children('.dragged_actions').children('.dragged_action:not(.edit_dragged)').addClass('hidden');
		});
		
		// $('body').on('click', '.label_dragged', function(){
		// 	var element = $(this);
		// 	element.closest('.dragged').find('.label_area').first().toggleClass('hidden visible');//.transition('slide down');
		// });

		$('body').on('change keyup', '.unit-title-label', function(){
			$('.dragged[data-count="'+$(this).closest('[data-uid]').data('uid')+'"]').find('.unit-wtitle').first().val($(this).val());
			$('.dragged[data-count="'+$(this).closest('[data-uid]').data('uid')+'"]').find('.unit-title').first().find('.detail').first().text($(this).val());
			$('.dragged[data-count="'+$(this).closest('[data-uid]').data('uid')+'"]').data('title', $(this).val());
		});

		$('body').on('change keyup', '.unit-name-label', function(){
			$(this).val($(this).val().replace(/[^\w ]+/g,'').replace(/ +/g,'_'));
			$('.dragged[data-count="'+$(this).closest('[data-uid]').data('uid')+'"]').find('.unit-name').first().val($(this).val());
			$('.dragged[data-count="'+$(this).closest('[data-uid]').data('uid')+'"]').find('.unit-title').first().attr('data-hint', $(this).val());
			$('.dragged[data-count="'+$(this).closest('[data-uid]').data('uid')+'"]').find('.dragged_name').first().text($(this).val());
			// $('.dragged[data-count="'+$(this).closest('[data-uid]').data('uid')+'"]').find('.unit-title').first().tooltipster({
			// 	content: $(this).data('hint'),
			// 	maxWidth: 300,
			// 	delay: 50,
			// 	debug: false,
			// 	contentAsHTML: true
			// });
		});

		$('body').on('click', '.unit-title', function(){
			var unit = $(this).closest('.dragged');
			$('#unitTitleToast').clone().removeClass('toast').toast({
				closeOnClick: false,
				closeIcon: true,
				position: 'bottom right',
				onShow: function(toast){
					$(toast).attr('data-uid', unit.data('count'));
					$(toast).find('.unit-title-label').val(unit.find('.unit-wtitle').first().val());
					$(toast).find('.unit-name-label').val(unit.find('.unit-name').first().val());
					$(toast).find('.unit-title-label').focus();
					$(toast).find(':input').on('keypress', function(e){
						if(e.keyCode == 13){
							$(this).blur();
							$(toast).toast('close');
						}
					});
					$(toast).find(':input').on('blur', function(e){
						setTimeout(function(){
							if($(toast).find(':input').is(':focus')){
								
							}else{
								$(toast).toast('close');
							}
						}, 200);
					});
				},
				onHide: function(toast){
					// if($(toast).find('.unit-title-label').is(':focus') || $(toast).find('.unit-name-label').is(':focus')){
					// 	return false;
					// }
					if($(toast).find(':input').is(':focus')){
						return false;
					}
				}
			})
		});
		
		$('body').on('click', '.delete_dragged', function(){
			var element = $(this);
			element.closest('.dragged').transition({
				'animation' : 'fly right', 
				'onComplete' : function(){
					element.closest('.dragged').remove();
					updateLists(false, 'inputs');
				}
			});
		});
		
		$('body').on('click', '.copy_dragged', function(){
			var element = $(this);
			element.closest('.dragged').addClass('loading');

			if(element.hasClass('safe_mode')){
				$.ajax({
					url: element.closest('.dragged').data('url'),
					//data: element.closest('.dragged').find(':input').serialize(),
					type: 'POST',
					async: false,
					success: function(result){
						var newFunc2 = $(result);
						
						element.closest('.dragged').find('.config_area').first().replaceWith(newFunc2);
						
						// $(newFunc2).find('.draggable-receiver').trigger('dragndrop.make.droppable');
						
						newFunc2.trigger('contentChange.basics', {'act':'cfw_unit_added'});

						// newFunc2.find('.edit_dragged').first().trigger('click');
						element.closest('.dragged_actions').find('.safe_mode').removeClass('safe_mode loading');
						// element.closest('.dragged').find('.config_area').first().toggleClass('hidden visible');
					}
				});
			}else{
				
			}

			$.ajax({
				url: element.data('url') + "&count=" + parseInt($('#units-count').val()),
				data: element.closest('.dragged').find(':input').serialize(),
				type: 'POST',
				async: false,
				//proccessData: false,
				success: function(result){
					var newFunc2 = $(result);
					
					element.closest('.dragged').after(newFunc2);
					element.closest('.dragged').removeClass('loading');
					
					$('#units-count').val(parseInt($('#units-count').val()) + 1 + element.closest('.dragged').find('.dragged').length);

					element.closest('.draggable-receiver').trigger('calculate');
					
					$(newFunc2).find('.draggable-receiver').trigger('dragndrop.make.droppable');
					newFunc2.trigger('contentChange.basics', {'act':'cfw_unit_added'});
				}
			});
		});
		
		// $('body').on('click', '.load_content', function(){
		// 	var element = $(this);
		// 	element.closest('.dragged').addClass('loading');
			
		// 	$.ajax({
		// 		url: element.data('url'),
		// 		type: 'POST',
		// 		success: function(result){
		// 			var newFunc2 = $(result);
					
		// 			element.closest('.dragged').removeClass('loading');
					
		// 			element.replaceWith(newFunc2);
		// 			newFunc2.trigger('contentChange.basics');
		// 		}
		// 	});
		// });
		
		$('body').on('click', '.refresh_dragged', function(){
			var element = $(this);
			element.closest('.dragged').addClass('loading');
			
			$.ajax({
				url: element.data('url') + "&utype="+element.closest('.dragged').data('utype')+"&count=" + (parseInt($('#units-count').val()) + 1),
				data: element.closest('.dragged').find(':input').serialize(),
				type: 'POST',
				//proccessData: false,
				success: function(result){
					var newFunc2 = $(result);
					
					element.closest('.dragged').after(newFunc2);
					element.closest('.dragged').removeClass('loading');
					
					$(newFunc2).find('.draggable-receiver').trigger('dragndrop.make.droppable');
					
					element.closest('.dragged').remove();
					newFunc2.trigger('contentChange.basics', {'act':'cfw_unit_added'});

					newFunc2.find('.edit_dragged').first().trigger('click');
				}
			});
		});
		
		$('body').on('g3.actions.dynamic.complete', '.save_block', function(e, data, is_json, newContent){
			if(!data.error){
				var save_button = $(this);
				var text = save_button.text();
				save_button.text($(this).data("completeMessage"));
				save_button.addClass('green');
				save_button.removeClass('black');
				
				setTimeout(function(){
					save_button.text(text);
					save_button.addClass('black');
					save_button.removeClass('green');
				}, 1000);
			}
		});
//////////////////////////////////////////////////////new drag drop
		// var dragged = false;
		// var active_droppable = false;
		// var droppables = [];

		// $('body').on('click', function(e){
		// 	if(dragged != false){
		// 		if($(e.target).closest('.draggable-receiver').length == 0){
		// 			$(dragged).remove();
		// 			dragged = false;
		// 		}
		// 	}
		// });

		// $('body').on('click', '.draggable', function(e){
		// 	e.stopPropagation();
		// 	console.log(this);
		// 	dragged = $(this).clone();
			
		// 	$('body').append($(dragged));
		// 	$(dragged).css('position', 'absolute');
		// });

		// $('body').on('mousemove', function(e){
		// 	if(dragged != false){
		// 		// console.log(e);
		// 		// console.log(dragged);
		// 		$(dragged).css('top', e.pageY+10+'px');
		// 		$(dragged).css('left', e.pageX+10+'px');
		// 	}
		// });

		// $('body').on('mouseover', '.draggable-receiver', function(e){
		// 	e.stopPropagation();
		// 	var droppable = $(this);
		// 	droppables.push(this);
		// 	// console.log(this);
		// 	if(dragged != false){
		// 		console.log(333);
		// 		droppable.addClass('active_droppable');
		// 		// droppable.append($('<div class="ui segment black dragged placeholder2">bbb</div>'));
		// 		if(dragged != false){
		// 			if(droppable.children('.ghost').length == 0){
		// 				var dragged_clone = $(dragged).clone().attr('style', '');
		// 				droppable.append(dragged_clone);
		// 				dragged_clone.addClass('ghost').find('.ui.button').addClass('labeled').css('opacity', '50%');
		// 			}
		// 		}
		// 		droppable.on('mousemove', function(em){
		// 			// console.log(em);
		// 			droppable.children('.dragged').each(function(Di, Dragged){
		// 				// console.log($(Dragged).offset());
		// 			});
		// 		});
		// 	}
		// });

		// $('body').on('mouseleave', '.draggable-receiver', function(e){
		// 	e.stopPropagation();
		// 	// console.log(this);
		// 	var droppable = $(this);
		// 	console.log(111);
		// 	// droppable.children('.ghost').remove();
		// 	droppable.removeClass('active_droppable');
		// 	droppable.off('mousemove');
		// 	console.log(222);
		// });
		// $('body').on('click', '.draggable-receiver', function(e){
		// 	e.stopPropagation();
		// 	var droppable = $(this);

		// 	if(dragged != false){
		// 		if($(dragged).data('info')){

		// 			// $(dragged).css('width', '');
		// 			var dragged_clone = $(dragged).clone().attr('style', '');
		// 			if(false && droppable.children('.dragged').length){
		// 				var distance = e.pageY;
		// 				var closest = droppable.children('.dragged').last();
		// 				droppable.children('.dragged').each(function(Di, Dragged){
		// 					if(e.pageY - $(Dragged).offset().top > distance){
		// 						closest = $(Dragged);
		// 					}
		// 				});
		// 			}else{
		// 				droppable.append(dragged_clone);
		// 			}
		// 			dragged_clone.addClass('ui form loading');
		// 			dragged_clone.find('.ui.button').addClass('labeled');
		// 			drop(dragged_clone, droppable);
		// 			$(dragged).remove();
		// 			console.log(dragged);
		// 			dragged = false;
		// 		}
		// 	}
		// });
		//////////////////////////////////////////////////////////////
		function initDroppable(e){
			e.stopPropagation();
			$(this).sortable({
				items: '.dragged', //this is causing the sorted item to get into children lists
				//containment:'parent',
				//axis:'y',
				connectWith: '.draggable-receiver:not(.drop_disabled)',
				scroll: false,
				//cursorAt: { left: 5, top: 0 },
				handle: '.sort_dragged',
				placeholder: 'ui button fluid compact green quti bg-grey600 text-white',
				start: function( event, ui ) {
					$('.tooltipster-base').remove();
					//$(ui.item).addClass('active_sortable');
				},
				sort: function( event, ui ) {
					$('.tooltipster-base').remove();
					//$(ui.item).addClass('active_sortable');
				},
				receive: function( event, ui ) {
					if($(ui.helper).data('info')){
						$(ui.helper).css('width', '');
						$(ui.helper).find('.segment').addClass('fluid loading');
						drop($(ui.helper), $(this));
					}
					// console.log(ui);
					// $(ui.item).find('.dragged_parent').first().val($(this).data('name'));
					$(ui.item).find('.parent_id').first().val($(this).attr('data-count'));
					$(ui.item).find('.parent_area').first().val($(this).attr('data-area'));
					
					$(this).trigger('calculate');
					$(ui.sender).trigger('calculate');
					//$(ui.item).find('.dragged_parent').first().val($(this).data('aname') + '/' + $(this).data('ename'));
					
				},
				update: function( event, ui ) {
				
				},
				stop: function( event, ui ) {
					$(ui.item).removeClass('active_sortable');
				},
				over: function( event, ui ) {
					$(this).addClass('active_droppable');
				},
				out: function( event, ui ) {
					$(this).removeClass('active_droppable');
				},
				tolerance: 'pointer'
			});
		}
		
		function drop(draggable, droppable){
			var dropInfo = draggable.data('info');
			var type = dropInfo.name;

			$('.empty_form_message').remove();
			
			$.ajax({
				url: draggable.data('url'),
				data: {'utype' : draggable.data('utype'), 'type' : type, 'count' : $('#units-count').val()},
				success: function(result){
					var newFunc = $(result);
					
					draggable.replaceWith(newFunc);
					$(newFunc).find('.draggable-receiver').trigger('dragndrop.make.droppable');
					//set the parent event value
					newFunc.each(function(nfk, newElem){
						// $(newElem).find('.dragged_parent').first().val(droppable.data('name'));
						$(newElem).find('.parent_id').first().val(droppable.data('count'));
						$(newElem).find('.parent_area').first().val(droppable.data('area'));
					});
					
					$('#units-count').val(parseInt($('#units-count').val()) + newFunc.closest('.dragged').length + newFunc.closest('.dragged').find('.dragged').length);
					//droppable.removeClass('loading');
					updateLists(false, 'inputs');
					newFunc.trigger('contentChange.basics', {'act':'cfw_unit_added'});
				}
			});
		}

		$('.pgroup-name').on('keyup change', function(){
			if($(this).val().length > 0){
				$(this).val($(this).val().replace(/[^\w\. ]+/g,'').replace(/ +/g,'_'));
				$(this).closest('.ui.form').find('.add-pgroup').prop('disabled', false).removeClass('disabled');
			}else{
				$(this).closest('.ui.form').find('.add-pgroup').prop('disabled', true).addClass('disabled');
			}
		});
		$('.add-pgroup').on('click', function(){
			var btn = this;

			$(btn).closest('.ui.form').addClass('loading');

			var pgroup = $(btn).closest('.ui.form').find('select[name="pgroup[name]"]');
			var pagedata = $(btn).closest('.ui.form').find(':input').serialize();

			pagedata = pagedata + '&pgcount='+$(':input[name="pgroups-count"]').val();

			$.ajax({
				url: $(btn).data('url'),
				data: pagedata,
				success: function(result){
					var page = $(result);
					$(btn).closest('.ui.form').removeClass('loading');

					$(btn).closest('.ui.form').before(page);
					$(':input[name="pgroups-count"]').val(parseInt($(':input[name="pgroups-count"]').val()) + 1);
					
					// page.find('.draggable-receiver').trigger('dragndrop.make.droppable');
					
					page.trigger('contentChange.basics');
					
					$(btn).closest('.ui.form').find('.pgroup-name').val('').trigger('change');
					// $('[data-receive="views"]').trigger('click');
				}
			});
		});

		$('body').on('click', '.add-page', function(){
			var btn = this;

			// $(btn).closest('.pgroup').addClass('loading');
			$(btn).closest('.pgroup').append('<div class="ui active dimmer top aligned"><div class="ui segment compact"><div class="ui active slow green double inline loader"></div></div></div>');
			// var pgroup = $(btn).closest('.ui.form').find('select[name="page[pgroup]"]');
			// var pagedata = $(btn).closest('.ui.form').find(':input').serialize();

			// if($('.segment[data-tab="pgroup-'+pgroup.val()+'-pages"]').length == 0){
			// 	pagedata = pagedata + '&newseq=1';
			// }

			var pagedata = 'newpage[name]=new_page_'+$(':input[name="pages-count"]').val()+'&pages-count='+$(':input[name="pages-count"]').val();
			$.ajax({
				url: $(btn).data('url'),
				data: pagedata,
				success: function(result){
					var page = $(result);
					$(btn).closest('.pgroup').children('.ui.dimmer.active').remove();

					$(':input[name="pages-count"]').val(parseInt($(':input[name="pages-count"]').val()) + 1);

					$('.segment[data-tab="pgroup-'+$(btn).closest('.pgroup').data('count')+'-pages"]').append(page);
					
					page.find('.draggable-receiver').trigger('dragndrop.make.droppable');
					
					page.trigger('contentChange.basics');
					$.G3.scrollTo(page);
					// $(btn).closest('.ui.form').find('.page-name').val('').trigger('change');
					$('[data-receive="views"]').trigger('click');
				}
			});
		});

		$('.pgroups').sortable({
			items: '.pgroup',
			scroll: false,
			handle: '.sort_pgroup',
			placeholder: 'ui segment inverted yellow',
			start: function( event, ui ) {
				$('.tooltipster-base').remove();
			},
			sort: function( event, ui ) {
				$('.tooltipster-base').remove();
			},
		});

		$('body').on('click', '.delete_pgroup', function(){
			var element = $(this);
			$('#pageGroupDelete').toast({
				displayTime: 0,
				position: 'bottom right',
				onApprove : function() {
					element.closest('.pgroup').transition({
						'animation' : 'fly right', 
						'onComplete' : function(){
							element.closest('.pgroup').remove();
							updateLists(false, 'pages');
						}
					});
				}
			});
			// element.closest('.pgroup').transition({
			// 	'animation' : 'fly right', 
			// 	'onComplete' : function(){
			// 		element.closest('.pgroup').remove();
			// 		updateLists(false, 'pages');
			// 	}
			// });
		});

		$('body').on('click', '.minimize_pgroup', function(){
			if(!$(this).hasClass('maximize')){
				$(this).closest('.pgroup').children('.tab').addClass('hidden');
				$(this).addClass('maximize').removeClass('minimize');
			}else{
				$(this).closest('.pgroup').children('.tab').removeClass('hidden');
				$(this).addClass('minimize').removeClass('maximize');
			}
		});
		
		// $('body').on('click', '.delete_block', function(){
		// 	var block_id = $(this).parent().attr('data-tab');
		// 	$('*[data-tab="'+block_id+'"]').remove();
		// });
		
		$('body').on('click', '.delete_area', function(){
			var element = $(this);
			$('#pageDelete').toast({
				displayTime: 0,
				position: 'bottom right',
				onApprove : function() {
					element.closest('.area').transition({
						'animation' : 'fly right', 
						'onComplete' : function(){
							element.closest('.area').remove();
							updateLists(false, 'pages');
						}
					});
				}
			});
			// element.closest('.area').transition({
			// 	'animation' : 'fly right', 
			// 	'onComplete' : function(){
			// 		element.closest('.area').remove();
			// 		updateLists(false, 'pages');
			// 	}
			// });
		});

		$('body').on('click', '.collapse_area', function(){
			$(this).closest('.main-area').find('.config_area').removeClass('visible').addClass('hidden');
		});
		
		$('.areas').sortable({
			items: '.area',
			connectWith: '.areas',
			scroll: false,
			handle: '.sort_area',
			placeholder: 'ui segment inverted yellow',
			start: function( event, ui ) {
				$('.tooltipster-base').remove();
				$('.area').not($(ui.item)).addClass('disabled');
			},
			sort: function( event, ui ) {
				$('.tooltipster-base').remove();
			},
			stop: function(event, ui){
				$(ui.item).find('.page_pgroup').first().val($(ui.item).closest('.pgroup').data('count'));
				$('.area').removeClass('disabled');
			},
		});
		
		// $('body').on('click', '.minimize_area', function(){
		// 	if($('[data-minimized="'+$(this).data('named')+'"]').val() == "1"){
		// 		$('[data-minimized="'+$(this).data('named')+'"]').val(0);
		// 	}else{
		// 		$('[data-minimized="'+$(this).data('named')+'"]').val(1);
		// 	}
		// });
		
		$('body').on('click', '.minimize_area.minimize_page', function(){
			$(this).closest('.main-area').children('[data-tab^="pages"]').not('.item.right').not('.item.title').toggleClass('hidden');
			$(this).toggleClass('minimize maximize');
			$(this).closest('.main-area').find('input.page_minimized').first().val($(this).closest('.main-area').find('input.page_minimized').first().val() == '0' ? '1' : '0');
		});
		
		// $('body').on('click', '.minimize_area.draggable-receiver-title', function(){
		// 	var element = $(this);
		// 	element.toggleClass('pointing below');
		// 	element.next('.draggable-receiver').transition({
		// 		'animation' : 'slide up', 
		// 		'onComplete' : function(){
		// 			//element.toggleClass('top attached');
		// 			element.find('.icon').toggleClass('down');
		// 			element.find('.icon').toggleClass('right');
		// 		}
		// 	});
		// });
		
		//preview
		jQuery('body').on('contentChange.basics', '*', function(e, settings){
			$(this).find('.preview-tab').on('click', function(){
				var tab = this;
				var section = $(tab).data('name');

				$('.segment[data-tab="'+$(tab).data('tab')+'"]').addClass('loading');
				
				var chunks = $('.units[data-name="'+section+'"]').find(':input');//.serializeArray();
				var data2 = $.G3.split(chunks, 900);
				
				$.ajax({
					url: $(tab).data('url'),
					data: {'_formchunks':data2},
					method: 'POST',
					success: function(result){
						var precontent = $('<div></div>').append(result);
						
						precontent.find('button[type="submit"]').each(function(b, but){
							$(but).prop('type', 'button');
						});
						
						$('.ui.tab[data-tab="'+$(tab).data('tab')+'"]').html(precontent);
						$('.ui.tab[data-tab="'+$(tab).data('tab')+'"]').removeClass('loading');
						
						$('.ui.tab[data-tab="'+$(tab).data('tab')+'"]').trigger('contentChange.basics');
					}
				});
			});
		});
		
		//manage scrolling position
		$('.unitsContainer').css('position', 'relative');
		var offset = false;
		var width = $('.unitsContainer').outerWidth();
		
		$(window).on('scroll', function(){
			if($('#unitsContainer').is(':visible')){
				if(offset == false){
					offset = $('#unitsContainer').offset();
				}
				if($(window).scrollTop() > offset.top - 25){
					$('.unitsContainer').css('position', 'sticky');
					$('.unitsContainer').css('top', 30);
					$('.unitsContainer').css('width', '100%');
					// $('.unitsContainer').css('top', $(window).scrollTop() - offset.top + 25);
				}else{
					$('.unitsContainer').css('top', 0);
					$('.unitsContainer').css('position', 'relative');
				}
			}
			if($('.accordion1').length){
				if($(window).scrollTop() > 0){
					$('.accordion1').each(function(Ai, Accordion){
						$(Accordion).css('max-height', ($(window).height() - $(Accordion).offset().top - 50 + $(window).scrollTop())+'px');
					});
				}
			}
		});

		if($('.accordion1').length){
			$('.accordion1').each(function(Ai, Accordion){
				$(Accordion).css('max-height', ($(window).height() - $(Accordion).offset().top - 50)+'px');
			});
		}
		
		//$('body').on('bodyChange.add', function(){
		jQuery('body').on('contentChange.basics', '*', function(e, settings){
			if(settings == undefined || settings['act'] == undefined){
				return false;
			}
			if($.inArray(settings['act'], ['boot', 'cfw_clone_added', 'cfw_unit_added', 'cfw_behavior_added']) > -1){
				$(this).find('.clonable_container').sortable({
					items: '> .clonable',
					scroll: false,
					handle: '.sort_clone',
					placeholder: 'ui segment inverted olive',
				});
			}
			
			$(this).find('.clonable[data-source="1"]:not(.hidden)').addClass('hidden').find(':input').prop('disabled', true);
		});
		
		$('body').on('click', '.add_clone', function(){
			if($(this).data('cloning') == 'copy'){
				var cloning = $(this).closest('.clonable[data-group="'+$(this).data('group')+'"]');
			}else{
				var cloning = $(this).closest('.clonable_container[data-group="'+$(this).data('group')+'"]').find('.clonable[data-group="'+$(this).data('group')+'"][data-source="1"]');
				
				if($(this).data('grouptype')){
					var cloning = $(this).closest('.clonable_container[data-group="'+$(this).data('group')+'"]').find('.clonable[data-group="'+$(this).data('group')+'"][data-grouptype="'+$(this).data('grouptype')+'"][data-source="1"]');
				}

				if($(this).data('subgroup')){
					var cloning = $(this).closest('.clonable[data-group="'+$(this).data('group')+'"]').find('.clonable[data-group="'+$(this).data('subgroup')+'"][data-source="1"]');
				}
			}
			// clone_fn(cloning, this);
			cloning.trigger('clone');
		});

		// function clone_fn(source, btn){
		$('body').on('clone', '.clonable', function(e){
			e.stopPropagation();
			var source = $(this);
			var group = $(source).data('group');
			var container = source.closest('.clonable_container[data-group="'+group+'"]');

			var dvalues = {};
			$.each(source.find('.ui.dropdown'), function(di, dropdown){
				dvalues[di] = $(dropdown).dropdown('get value');
			});
			
			var new_item = source.clone();
			if(new_item.attr('data-source') == 1){
				new_item.removeClass('hidden');
				new_item.removeAttr('data-source');
				var exclude = [];
				if(new_item.find('.clonable[data-source="1"]').length){
					exclude = new_item.find('.clonable[data-source="1"]').find(':input');
				}
				new_item.find(':input').not(exclude).prop('disabled', false);
				new_item.find('.ui.dropdown').removeClass('disabled');
			}
			//remove dropdowns from the clone and use plain select instead
			$.each(new_item.find('.ui.dropdown'), function(di, dropdown){
				var select = $(dropdown).find('select').first();
				select.attr('class', $(dropdown).attr('class'));
				$(dropdown).attr('class', 'remove_dropdown')
				$(dropdown).after(select);
				$(select).val(dvalues[di]);
			});
			new_item.find('.remove_dropdown').remove();

			new_item.find('.delete_clone[data-group="'+group+'"]').removeClass('hidden');
			
			var group_index = 1 + parseInt(container.attr('data-lastindex'));
			container.attr('data-lastindex', group_index);
			new_item.attr('data-cloneindex', group_index);
			
			var re = new RegExp('#'+group+'#', 'g');
			
			new_item.find('[data-origin]').each(function(i, item){
				var props = JSON.parse($(item).attr('data-origin'));
				$.each(props, function(propname, prop){
					var newprop = prop.replace(re, group_index);
					//match parent clonables
					$.each(container.parents('.clonable[data-group]'), function(ci, parent_clone){
						newprop = newprop.replace(new RegExp('#'+$(parent_clone).data('group')+'#', 'g'), $(parent_clone).attr('data-cloneindex'));
					});
					//match child clonables
					$.each(new_item.find('.clonable[data-group]'), function(ci, child_clone){
						newprop = newprop.replace(new RegExp('#'+$(child_clone).data('group')+'#', 'g'), $(item).closest('.clonable[data-group="'+$(child_clone).data('group')+'"]').attr('data-cloneindex'));
					});
					
					$(item).attr(propname, newprop);
				});
			});
			
			if(!source.is('[data-source="1"]')){
				source.after(new_item);
			}else{
				container.append(new_item);
			}
			
			new_item.trigger('contentChange', {'act':'cfw_clone_added'});
		});

		$('body').on('click', '.delete_clone', function(){
			$(this).closest('.clonable').remove();
		});
		
		
		$('[data-apply="1"]').on('click', function(e){
			e.preventDefault();
			var button = $(this);
			button.closest('form').addClass('loading');

			if(jQuery.G3.tinymce != undefined){
				jQuery.G3.tinymce.remove('textarea[data-editor]');
			}
			
			var chunks = button.closest('form').find(':input');//.serializeArray();
			var data2 = $.G3.split(chunks, 900);
			
			$.ajax({
				url: button.data('url'),
				data: {'_formchunks':data2},
				method: 'POST',
				success: function(result){
					button.closest('form').removeClass('loading');
					$('body').toast({
						class: 'success',
						message: JSON.parse(result)['success'],
						position: "top center",
					});
				}
			});
		});
		
		
		//manage view events clones dropdowns
		$('body').on('change.events', '[data-cfwizardjob="content-switcher"]', function(){
			var select = this;
			if($(select).find('option[value="'+$(select).val()+'"]').length){
				var settings = JSON.parse($(select).find('option[value="'+$(select).val()+'"]').first().attr('data-settings'));
				$.each(settings, function(act, items){
					$.each(items, function(ki, item){
						var target = $(select).closest('.clonable').find(item);
						var exclude = [];
						if(target.find('.clonable[data-source="1"]').length){
							exclude = target.find('.clonable[data-source="1"]').find(':input');
						}
						if(act == 'show'){
							target.removeClass('hidden');
							target.find(':input').not(exclude).prop('disabled', false);
							target.find('.ui.dropdown').removeClass('disabled');
							$.each(target.find(':input'), function(ink, inp){
								if($(inp).attr('dname')){
									$(inp).attr('name', $(inp).attr('dname'))
								}
							})
						}else if(act == 'hide'){
							target.addClass('hidden');
							target.find(':input').prop('disabled', true);
							$.each(target.find(':input'), function(ink, inp){
								if($(inp).attr('name')){
									$(inp).attr('dname', $(inp).attr('name'))
									$(inp).removeAttr('name')
								}
							})
						}
					})
				});
			}
		});

		$('body').on('change.events', '[data-cfwizardjob="view-event-source"]', function(){
			var select = this;
			if($(this).prop('disabled') || $(select).val() == null){
				return false;
			}
			var option = $(select).find('option[value="'+$(select).val()+'"]').first();
			var type = $('.dragged[data-count="'+$(select).val()+'"]').first().attr('data-type');

			// $(select).closest('.clonable').find('.feact').find('.ui.dropdown').dropdown('change values', []);
			// $(select).closest('.clonable').find('.feact').find('.ui.dropdown').dropdown('set exactly', null);
			// $(select).closest('.clonable').find('.feact').find('.ui.dropdown').dropdown('refresh');

			// $(select).closest('.clonable').find('.feact').find('.ui.dropdown').dropdown('clear', true);
			$(select).closest('.clonable').find('.feact').find('.ui.dropdown').find('.menu').find('.item').removeClass('hidden');

			$(select).closest('.clonable').find('.feact').find('select').find('option').each(function(Opi, Option){
				if($(Option).data('vtypes') != null){
					if($(Option).data('vtypes') != true && $.inArray(type, $(Option).data('vtypes')) == -1){
						$(Option).closest('.ui.dropdown').find('.menu').find('.item[data-value="'+$(Option).attr('value')+'"]').addClass('hidden');
					}
				}
			});

			// $(select).closest('.clonable').find('.feact').find('.ui.dropdown').find('.menu').find('.item:not(.hidden)').first().addClass('active selected');
			var selected_value = $(select).closest('.clonable').find('.feact').find('.ui.dropdown').dropdown('get value');
			if($(select).closest('.clonable').find('.feact').find('.ui.dropdown').find('.menu').find('.item[data-value="'+selected_value+'"]').hasClass('hidden')){
				$(select).closest('.clonable').find('.feact').find('.ui.dropdown').dropdown('set exactly', $(select).closest('.clonable').find('.feact').find('.ui.dropdown').find('.menu').find('.item:not(.hidden)').first().data('value'));
			}
			// $(select).closest('.clonable').find('.feact').find('.ui.dropdown').find('div.text').text($(select).closest('.clonable').find('.feact').find('.ui.dropdown').find('.menu').find('.item:not(.hidden)').first().data('text'));
			
			// $(select).closest('.clonable').find('.feact').addClass('hidden');
			// $(select).closest('.clonable').find('.feact').find(':input').prop('disabled', true);

			// $(select).closest('.clonable').find('.feact_'+type).find(':input').prop('disabled', false);
			// $(select).closest('.clonable').find('.feact_'+type).find('.disabled').removeClass('disabled');
			// $(select).closest('.clonable').find('.feact_'+type).removeClass('hidden');
			
			// $(select).closest('.clonable').find('.feact').find('[data-cfwizardjob="content-switcher"]').first().trigger('change.events');
		});

		jQuery('body').on('contentChange.basics', '*', function(e, settings){
			if(settings == undefined || settings['act'] == undefined){
				return false;
			}
			if($.inArray(settings['act'], ['boot', 'cfw_clone_added', 'cfw_unit_added']) > -1){
				$(this).find('[data-cfwizardjob="view-event-source"]:not(:disabled)').trigger('change.events');
				$(this).find('[data-cfwizardjob="content-switcher"]:not(:disabled)').trigger('change.events');
			}
		});
		
		//manage behaviors selections
		$('body').on('change.events', '[data-cfwizardjob="behavior-selection"]', function(e){
			var select = this;
			var behaviors_settings = $(select).closest('.behaviors_settings');
			
			$(behaviors_settings).find('.behavior_config').addClass('hidden');
			$(behaviors_settings).find('.behavior_config').find(':input').prop('disabled', true);

			var values = $(select).closest('.ui.dropdown').dropdown('get value');
			
			$('.item[data-tab="'+$(select).closest('.behaviors_settings').data('tab')+'"]').find('label').remove();
			if(values){
				$('.item[data-tab="'+$(select).closest('.behaviors_settings').data('tab')+'"]').append('<label class="ui label black basic">'+values.length+'</label>');
			}

			jQuery.each(values, function(tk, behavior_value){
				var exclude = [];
				
				if($(behaviors_settings).find('.behavior_config.'+behavior_value+'_config').length){
					if($(behaviors_settings).find('.behavior_config.'+behavior_value+'_config').find('.clonable[data-source="1"]').length){
						exclude = $(behaviors_settings).find('.behavior_config.'+behavior_value+'_config').find('.clonable[data-source="1"]').find(':input');
					}
					$(behaviors_settings).find('.behavior_config.'+behavior_value+'_config').removeClass('hidden');
					$(behaviors_settings).find('.behavior_config.'+behavior_value+'_config').find('.ui.dropdown').removeClass('disabled');
					$(behaviors_settings).find('.behavior_config.'+behavior_value+'_config').find(':input').not(exclude).prop('disabled', false);
					updateLists($(behaviors_settings).find('.behavior_config.'+behavior_value+'_config'));
				}else{
					if($(select).find('option[value="'+behavior_value+'"]').first().data('config').toString() == '1'){
						$(select).closest('.ui.dropdown').addClass('disabled');
						$(behaviors_settings).find('.behaviors_config_area').addClass('form loading');
						var unit_data = {};
						if($(select).closest('.config_area').length){
							unit_data = $(select).closest('.config_area').find(':input[type=hidden]').serialize();
						}
						$.ajax({
							url: $(select).data('url')+'&utype='+$(select).data('utype')+'&type='+$(select).data('type')+'&count='+$(select).data('count')+'&behavior='+behavior_value,
							data: unit_data,
							success: function(result){
								var Config = $(result);
								
								$(behaviors_settings).find('.behaviors_config_area').removeClass('form loading');
								$(behaviors_settings).find('.behaviors_config_area').append(Config);
								Config.trigger('contentChange.basics', {'act':'cfw_behavior_added'});
								Config.removeClass('hidden');
								$(select).closest('.ui.dropdown').removeClass('disabled');
							}
						});
					}
				}
			});
		});
		
		jQuery('body').on('contentChange.basics', '*', function(e, settings){
			if(settings == undefined || settings['act'] == undefined){
				return false;
			}
			if($.inArray(settings['act'], ['cfw_unit_added']) > -1){
				$(this).find('[data-cfwizardjob="behavior-selection"]').trigger('change.events');
			}
		});
		
		jQuery('body').on('contentChange.basics', '*', function(e, settings){
			updateLists(this, true);
		});

		jQuery('body').on('click', 'select[data-list]', function(e){
			// console.log(this);
		});

		jQuery('.cheatsheet').on('click', function(e){
			$('.ui.modal.shortcodes').modal('show');
		});
	});

	function updateLists(area, type, uid){
		if(jQuery.fn.dropdown.settings.cf == undefined){
			jQuery.fn.dropdown.settings.cf = {};
			type = true;
		}
		// if(type == 'inputs' || type == true){
		// 	if(uid != undefined){
		// 		// var unit = $('.dragged[data-count="'+uid+'"]').first();
		// 		// if(unit.is('.dragged[data-utype="views"]')){
		// 		// 	jQuery.fn.dropdown.settings.cf.inputsList[uid] = {'name':jQuery(unit).data('title'), 'value':jQuery(unit).data('count'), 'vtype':jQuery(unit).data('type')};
		// 		// }
		// 	}else{
		// 		jQuery.fn.dropdown.settings.cf.unitsList = {};
		// 		jQuery.each(jQuery('.dragged[data-utype]'), function(vi, unit){
		// 			jQuery.fn.dropdown.settings.cf.unitsList[jQuery(unit).data('count')] = {'name':jQuery(unit).data('title'), 'value':jQuery(unit).data('count'), 'vtype':jQuery(unit).data('type'), 'utype':jQuery(unit).data('utype'), 'ugroups':jQuery(unit).data('ugroups')};
		// 		});

		// 		jQuery.fn.dropdown.settings.cf.inputsList = {};
		// 		jQuery.each(jQuery('.dragged[data-utype="views"]'), function(vi, unit){
		// 			if(jQuery(unit).find('.config_area').first().find('.field_label').length){
		// 				jQuery.fn.dropdown.settings.cf.inputsList[jQuery(unit).data('count')] = {'name':jQuery(unit).data('title'), 'value':jQuery(unit).data('count'), 'vtype':jQuery(unit).data('type')};
		// 			}
		// 		});
		// 		jQuery.fn.dropdown.settings.cf.viewsList = {};
		// 		jQuery.each(jQuery('.dragged[data-utype="views"]'), function(vi, unit){
		// 			jQuery.fn.dropdown.settings.cf.viewsList[jQuery(unit).data('count')] = {'name':jQuery(unit).data('title'), 'value':jQuery(unit).data('count'), 'vtype':jQuery(unit).data('type')};
		// 		});
		// 		jQuery.fn.dropdown.settings.cf.fnsList = {};
		// 		jQuery.each(jQuery('.dragged[data-utype="functions"]'), function(vi, unit){
		// 			jQuery.fn.dropdown.settings.cf.fnsList[jQuery(unit).data('count')] = {'name':jQuery(unit).data('title'), 'value':jQuery(unit).data('count'), 'vtype':jQuery(unit).data('type')};
		// 		});
		// 	}
		// }
		// if(type == 'pages' || type == true){
		// 	jQuery.fn.dropdown.settings.cf.pagesList = {};
		// 	jQuery.each(jQuery('.pages-tab'), function(pi, page){
		// 		jQuery.fn.dropdown.settings.cf.pagesList[jQuery(page).data('value')] = {'name':jQuery(page).data('text'), 'value':jQuery(page).data('value')};
		// 	});
		// }

		updateDropdown = function(dropdown){
			var value = jQuery(dropdown).closest('.ui.dropdown').dropdown('get value');
			var selector = selector = jQuery(dropdown).attr('data-list');
			// if(jQuery(dropdown).attr('data-list') == 'pagesList'){
			// 	selector = '.area';
			// }else{
			// 	selector = jQuery(dropdown).attr('data-list');
			// }
			var title = '';
			var new_values = {};
			var selected = value;
			if(!jQuery.isArray(selected)){
				if(selected){
					selected = [selected];
				}else{
					selected = [];
				}
			}
			if(jQuery(dropdown).data('types') == undefined){
				jQuery.each(jQuery(selector), function(vi, unit){
					// if(jQuery(unit).is(jQuery(dropdown).closest('.dragged'))){
					// 	return;
					// }
					title = jQuery(unit).data('title');
					if(selector != '.pagesList'){
						title = '<span class="ui text blue">'+jQuery(unit).closest('.pagesList').attr('data-title')+'</span> - '+jQuery(unit).data('title');
					}
					new_values['u'+jQuery(unit).data('count')] = {'name':title, 'value':jQuery(unit).data('count'), 'vtype':jQuery(unit).data('type')};
				});
			}else{
				var list_types = JSON.parse(jQuery(dropdown).attr('data-types'));
				jQuery.each(jQuery(selector), function(vi, unit){
					if(jQuery.inArray(jQuery(unit).data('type'), list_types) > -1){
						title = jQuery(unit).data('title');
						if(selector != '.pagesList'){
							title = '<span class="ui text blue">'+jQuery(unit).closest('.pagesList').attr('data-title')+'</span> - '+jQuery(unit).data('title');
						}
						new_values['u'+jQuery(unit).data('count')] = {'name':title, 'value':jQuery(unit).data('count'), 'vtype':jQuery(unit).data('type')};
					}
				});
			}
			// console.log(new_values);
			// console.log(jQuery(dropdown).closest('.ui.dropdown'));
			jQuery.each(jQuery(dropdown).find('option'), function(si, option){
				var sValue = jQuery(option).attr('value');
				if(!('u'+sValue in new_values) && sValue.trim().length){
					new_values['u'+sValue] = {'name':sValue, 'value':sValue, 'vtype':''};
				}
			});
			if(Object.keys(new_values).length == 0){
				//new_values['u0'] = {'name':'', 'value': ''};
			}
			// if(jQuery(dropdown).data('types') == undefined){
			// 	var new_values = jQuery.fn.dropdown.settings.cf[jQuery(dropdown).attr('data-list')];
			// }else{
			// 	var list_types = JSON.parse(jQuery(dropdown).attr('data-types'));
			// 	var new_values = [];
			// 	jQuery.each(jQuery.fn.dropdown.settings.cf[jQuery(dropdown).attr('data-list')], function(vi, udata){
			// 		if(jQuery.inArray(udata['vtype'], list_types) > -1){
			// 			new_values.push(udata);
			// 		}
			// 	});
			// }
			jQuery(dropdown).closest('.ui.dropdown').dropdown('change values', new_values);
			jQuery(dropdown).closest('.ui.dropdown').dropdown('set exactly', value);
			jQuery(dropdown).closest('.ui.dropdown').dropdown('refresh');
		};
		
		if(area){
			jQuery.each(jQuery(area).find('select[data-list]'), function(di, dropdown){
				if(jQuery(dropdown).closest('.ui.dropdown').length){
					

					if(!jQuery(dropdown).prop('disabled')){
						updateDropdown(dropdown);
					}
					// jQuery(dropdown).closest('.ui.dropdown').dropdown('setting', 'onShow', updateDropdown);
					jQuery(dropdown).closest('.ui.dropdown').on('click', function(){
						if(jQuery(dropdown).closest('.ui.dropdown').dropdown('is hidden')){
							updateDropdown(dropdown);
							jQuery(dropdown).closest('.ui.dropdown').dropdown('show');
						}
					});
				}
			});
		}
	}
	///start search code not needed anymore
	function refresh_lists(){
		// jQuery.fn.dropdown.settings.cf = {};
		// jQuery.fn.dropdown.settings.cf.viewsList = {};
		// jQuery.each(jQuery('.dragged[data-utype="views"]'), function(vi, view){
		// 	if(jQuery(view).find('.config_area').first().find('.field_label').length){
		// 		jQuery.fn.dropdown.settings.cf.viewsList[jQuery(view).data('count')] = {'name':jQuery(view).find('.config_area').first().find('.field_label').first().val(), 'value':jQuery(view).data('count')};
		// 	}
		// });
	}

	function dynamic_searches(){
		// jQuery.fn.search.settings.templates.special = function(response){
		// 	var html = '';
		// 	jQuery.each(response['results'], function(ri, result){
		// 		html += '<a class="result" data-id="'+result['idr']+'"><div class="content"><div class="title">'+result['title']+'</div></div></a>';
		// 	});
		// 	return html;
		// };

		// jQuery('body').on('contentChange.basics', '*', function(e, settings){
		// 	jQuery(this).find('.ui.search.cfwsearch').not('[data-gready]').each(function(r, widget){
		// 		jQuery(widget).attr('data-gready', 1);

		// 		jQuery(widget).search({
		// 			type: 'special',
		// 			minCharacters: 0,
		// 			maxResults: 999,
		// 			source: jQuery.cfwizard[jQuery(widget).attr('data-list')],
		// 			onSelect: function(result, response){
		// 				jQuery(this).find('input.xprompt').first().val(result['title']);
		// 				jQuery(this).find('input[type=hidden]').first().val(result['idr']);
		// 			},
		// 		});

		// 		if(jQuery(widget).find('input[type=hidden]').first().val()){
		// 			jQuery(widget).find('.xprompt').first().val(jQuery.cfwizard[jQuery(widget).attr('data-list')][jQuery(widget).find('input[type=hidden]').first().val()]['title']);
		// 		}
		// 	});
		// });

		// jQuery('body').on('click', '.ui.search.cfwsearch .ui.input .clear', function(e){
		// 	jQuery(this).closest('.ui.search.cfwsearch').find('input.xprompt').val('');
		// 	jQuery(this).closest('.ui.search.cfwsearch').find('input[type=hidden]').first().val('');
		// });

		// jQuery('body').on('focus', '.ui.search.cfwsearch .ui.input .xprompt', function(){
		// 	var widget = jQuery(this).closest('.ui.search.cfwsearch');
		// 	jQuery(widget).search('setting', 'source', jQuery.cfwizard[jQuery(widget).attr('data-list')]);
		// 	jQuery(widget).search('search local', '');
		// 	jQuery(widget).find('.result').removeClass('active');
		// 	var value = jQuery(widget).find('input[type=hidden]').first().val();
		// 	jQuery(widget).find('.result[data-id="'+value+'"]').addClass('active');
		// }).on('blur', '.ui.search.cfwsearch .ui.input .xprompt', function(){
		// 	var prompt = this;
		// 	setTimeout(function() {
		// 		jQuery(prompt).closest('.ui.search.cfwsearch').search('hide results').delay(300);
		// 	}, 100);
		// }).on('input', '.ui.search.cfwsearch .ui.input .xprompt', function(e){
		// 	e.preventDefault();
		// });
	}
	//end search code not needed anymore
	
	function saveform(btn){
		btn.closest('form').addClass('loading');
		if(jQuery.G3.tinymce != undefined){
			jQuery.G3.tinymce.remove('textarea[data-editor]');
		}
		
		var chunks_counter = 0;
		var chunks = btn.closest('form').find(':input[name^="Connection"]');//.serialize().match(/.{1,100}/g);
		var data2 = jQuery.G3.split(chunks, 900);
		
		chunks.prop('disabled', true);
		jQuery.each(data2, function(i, chunk){
			btn.closest('form').append(jQuery('<textarea></textarea>').css('display', 'none').attr('name', '_formchunks['+i+']').val(chunk));
		});
		btn.closest('form').submit();
	}
<?php
	$jscode = ob_get_clean();
	\GApp3::document()->addJsCode($jscode);
?>
</script>
<div class="ui calendar hidden quti bg-black bg-blue bg-green bg-red text-white rounded-1 p-1 mx-1 bg-blue200 bg-red200 bg-green200"></div>
<i class="icon test hidden"></i>