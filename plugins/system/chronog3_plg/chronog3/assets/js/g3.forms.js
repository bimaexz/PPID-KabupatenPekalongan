(function($){
	if($.G3 == undefined){
		$.G3 = {};
	}
	$.G3.forms = {};

	$.G3.forms.quickUpload = function(Widget, requestData){
		$.ajax({
			xhr: function(){
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener('progress', function(evt){
					if(evt.lengthComputable){
						var percentComplete = evt.loaded / evt.total;
						percentComplete = parseInt(percentComplete * 100);
						console.log(percentComplete);
						// $(Widget).find('.progress').progress('set percent', percentComplete);
						
						if(percentComplete === 100){
							//container.find('.progress').hide();
						}
					}
				}, false);
				return xhr;
			},
			url: $(Widget).data('url'),
			type: "POST",
			data: requestData,
			processData: false,
			contentType: false,
			beforeSend: function(){
				$(Widget).addClass('ui form loading');
			},
			error: function(xhr, textStatus, message){
				$(element).removeClass('loading');
				alert(textStatus+':'+message);
			},
			success: function(data, textStatus, xhr){
				$(Widget).removeClass('ui form loading');
				//$(Widget).append(data);
			}
		});
	}
	
	$.G3.forms.initializeForm = function (Form){
		var validationRules = {};
		
		jQuery.fn.form.settings.rules.required = function(value){
			if(value){
				return true;
			}else{
				return false;
			}
		};
		
		jQuery.fn.form.settings.rules.email = function(value){
			if(value.match(/^([a-zA-Z0-9_\.\-\+%])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{1,11})+$/)){
				return true;
			}else{
				return false;
			}
		};
		
		jQuery.fn.form.settings.rules.minChecked = function(value, minChecked){
			jQuery(this).closest('.mainfield').off('change.validation').on('change.validation', ':input', function(){
				Form.form('validate form');
			});
			
			if(jQuery(this).closest('.mainfield').find(':input:checked').length >= minChecked){
				return true;
			}else{
				return false;
			}
		};
		
		jQuery.fn.form.settings.rules.maxChecked = function(value, maxChecked){
			jQuery(this).closest('.mainfield').off('change.validation').on('change.validation', ':input', function(){
				Form.form('validate form');
			});
			
			if(jQuery(this).closest('.mainfield').find(':input:checked').length > maxChecked){
				return false;
			}else{
				return true;
			}
		};
		
		Form.find('[data-validationrules]').each(function(i, inp){
			if(jQuery(inp).data('validationrules').disabled == undefined || jQuery(inp).data('validationrules').disabled == 0){
				validationRules['field'+i] = jQuery(inp).data('validationrules');
			}
		});
		
		Form.form({
			inline : true,
			on : 'blur',
			fields: validationRules,
			onInvalid: function(){
				if($(this).closest('.mainfield').find('.error-msg').length == 0){
					$(this).closest('.mainfield').append('<span class="ui red text small error-msg" style="display:block;padding-top:3px;"></span>');
				}
				$(this).closest('.mainfield').find('.error-msg').text($(this).closest('.field').find('.ui.red.prompt').first().text());
				$(this).closest('.mainfield').find('.error-msg').removeClass('hidden');
				$(this).closest('.field').find('.ui.red.prompt').remove();
				jQuery(this).closest('.mainfield').addClass('error');
			},
			onValid: function(){
				$(this).closest('.mainfield').find('.error-msg').addClass('hidden');
				jQuery(this).closest('.mainfield').removeClass('error');
			}
		});

		Form.on('reset', function(){
			Form.find(':input').trigger('change');
			jQuery.each(Form.find(':input[type=hidden][data-for]'), function(Fi, Hidden){
				if($(Hidden).attr('data-for') == 'ui rating'){
					$(Hidden).closest('.field').find('.ui.rating').first().rating('clear rating');
				}
			});
		});

		Form.on('click', 'button[data-clear]', function(){console.log(2);
			Form.find(':input').not(':button, :submit, :reset, :radio, :checkbox, [data-cftoken]').val('');
			Form.find(':input:checkbox, :input:radio').prop('checked', false);
			Form.find('select').find('option').removeAttr('selected');
			Form.find('select').closest('.ui.dropdown').dropdown('clear');
			Form.find(':input').trigger('change');
		});

		Form.on('click', 'button[type="reset"]', function(){
			Form.form('reset');
			// Form.find('input[type="hidden"]').trigger('change.reset');
		});

		Form.find('input[type="file"].vfile').each(function(fi, file){
			$(file).closest('.field').find('.vinput').first().on('click', function(){
				$(file).trigger('click');
			});
			if($(file).data('files') && $(file).data('files').length > 0){
				var text = '<ul class="ui list" style="text-align:left;">';
				$.each($(file).data('files'), function(Fi, SFile){
					$(file).before('<input type="hidden" name="'+$(file).attr('name')+'" value="'+SFile+'" />');
					text = text + '<li><i class="icon save"></i>' + SFile + '</li>';
				});
				text = text + '</ul>';
				$(file).closest('.mainfield').find('.vfilename').first().html(text);
			}
		});

		Form.on('change', 'input[type="file"].vfile', function(){
			var file = this;
			var vfilename = $(file).closest('.mainfield').find('.vfilename').first();
			if($(file).val().length){
				var flist = [];
				requestData = new FormData();
				$.each($(file).get(0).files, function(fi, File){
					flist.push(File['name']);
					// requestData.append('test_file', File);
				});
				vfilename.text(flist.join(', '));

				$(file).closest('.mainfield').find('input[type="hidden"]').remove();
				// $.G3.forms.quickUpload($(file).closest('.mainfield'), requestData);
			}else{
				vfilename.text(vfilename.attr('data-text'));
			}
		});
	}

	$.G3.forms.getInput = function(Field){
		var Input = null;
		if($(Field).data('vtype') == 'checkbox'){
			Input = $(Field).find('[type="checkbox"]').first();
		}else if($(Field).data('vtype') == 'select'){
			Input = $(Field).find('select').first();
		}else if($(Field).data('vtype') == 'radios'){
			Input = $(Field).find(':input[type="radio"]');
		}else if($(Field).data('vtype') == 'checkboxes'){
			Input = $(Field).find(':input[type="checkbox"]');
		}else{
			Input = $(Field).find(':input').first();
		}

		return Input;
	}

	$.G3.forms.getVal = function(Field){
		FieldValue = '';
		if($(Field).data('vtype') == 'checkbox'){
			FieldValue = ($(Field).find('[type="checkbox"]').first().is(':checked') ? $(Field).find('[type="checkbox"]').first().val() : '');
		}else if($(Field).data('vtype') == 'select'){
			FieldValue = $(Field).find('select').first().val();
		}else if($(Field).data('vtype') == 'radios'){
			FieldValue = $(Field).find(':input:checked').first().val();
		}else if($(Field).data('vtype') == 'checkboxes'){
			FieldValue = [];
			jQuery.each($(Field).find(':input:checked'), function(ci, check){
				FieldValue.push($(check).val());
			});
		}else{
			FieldValue = $(Field).find(':input').first().val();
		}

		if(FieldValue == null){
			FieldValue = '';
		}

		return FieldValue;
	}

	$.G3.forms.setVal = function(Field, value){
		if(!jQuery.isArray(value)){
			value = [value];
		}
		if($(Field).data('vtype') == 'checkbox'){
			$(Field).find('[type="checkbox"]').first().prop('checked', true);
		}else if($(Field).data('vtype') == 'select'){
			$(Field).find('.ui.dropdown').dropdown('set exactly', value);
		}else if($(Field).data('vtype') == 'radios'){
			jQuery.each($(Field).find(':input[type=radio]'), function(ri, Radio){
				if(jQuery.inArray($(Radio).attr('value'), value) > -1){
					$(Radio).prop('checked', true);
				}
			});
		}else if($(Field).data('vtype') == 'checkboxes'){
			jQuery.each($(Field).find(':input[type=checkbox]'), function(ri, Radio){
				if(jQuery.inArray($(Radio).attr('value'), value) > -1){
					$(Radio).prop('checked', true);
				}
			});
		}else{
			$(Field).find(':input').first().val(value[0]);
		}
	}

	$.G3.forms.testCondition = function(e, eData, conditionSource, condition){
		var cinput_value = $.G3.forms.getVal(conditionSource);
		// console.log('Condition source input value: '+cinput_value);
		var condition_result = false;

		if(condition['action'] == '=='){
			if(!jQuery.isArray(cinput_value)){
				cinput_value = [cinput_value];
			}
			condition_result = (jQuery(cinput_value).filter(condition['value']).length > 0);
		}else if(condition['action'] == '!='){
			if(!jQuery.isArray(cinput_value)){
				cinput_value = [cinput_value];
			}
			condition_result = (jQuery(cinput_value).filter(condition['value']).length == 0);
		}else if(condition['action'] == '<'){
			condition_result = (parseFloat(cinput_value) < parseFloat(condition['value'][0]));
		}else if(condition['action'] == '<='){
			condition_result = (parseFloat(cinput_value) <= parseFloat(condition['value'][0]));
		}else if(condition['action'] == '>'){
			condition_result = (parseFloat(cinput_value) > parseFloat(condition['value'][0]));
		}else if(condition['action'] == '>='){
			condition_result = (parseFloat(cinput_value) >= parseFloat(condition['value'][0]));
		}else if(condition['action'] == 'in'){
			if(!jQuery.isArray(cinput_value)){
				cinput_value = [cinput_value];
			}
			condition_result = (jQuery(cinput_value).filter(condition['mvalue']).length > 0);
		}else if(condition['action'] == '!in'){
			if(!jQuery.isArray(cinput_value)){
				cinput_value = [cinput_value];
			}
			condition_result = (jQuery(cinput_value).filter(condition['mvalue']).length == 0);
		}else if(condition['action'] == '!empty'){
			condition_result = (cinput_value.length > 0);
		}else if(condition['action'] == 'empty'){
			condition_result = (cinput_value.length == 0);
		}else if(condition['action'] == 'regex'){
			var pat = condition['value'][0];
			var exp = new RegExp(pat.slice(1, -1));
			condition_result = exp.test(cinput_value);
		}else if(condition['action'] == 'triggers' && e.type == 'triggers'){
			if(jQuery(e.currentTarget).is($.G3.forms.getInput(conditionSource)) || jQuery(e.currentTarget).is(conditionSource)){
				condition_result = (jQuery([eData['name']]).filter(condition['value']).length > 0);;
			}
			if(conditionSource.is('[data-isinput]')){
				if(jQuery(e.currentTarget).is($.G3.forms.getInput(conditionSource))){
					condition_result = (jQuery([eData['name']]).filter(condition['value']).length > 0);
				}
			}else{
				if(jQuery(e.currentTarget).is(conditionSource)){
					condition_result = (jQuery([eData['name']]).filter(condition['value']).length > 0);
				}
			}
		}else if(condition['action'] == e.type){
			if(conditionSource.is('[data-isinput]')){
				if(jQuery(e.currentTarget).is($.G3.forms.getInput(conditionSource))){
					condition_result = true;
				}
			}else{
				if(jQuery(e.currentTarget).is(conditionSource)){
					condition_result = true;
				}
			}
		}

		return condition_result;
	}

	$.G3.forms.setupEvents = function (Page){
		Page.on('show.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$(this).find('.mainfield').addBack().removeClass('hidden');
			}
		});
		Page.on('hide.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$(this).find('.mainfield').addBack().addClass('hidden');
			}
		});
		Page.on('toggle_show.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				if($(this).find('.mainfield').addBack().hasClass('hidden')){
					$(this).trigger('show.gevents', {'result':true});
				}else{
					$(this).trigger('hide.gevents', {'result':true});
				}
			}
		});

		Page.on('enable.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$(this).removeClass('disabled');
				$(this).find(':input').prop('disabled', false);
				$(this).find('.ui.dropdown').removeClass('disabled');
			}
		});
		Page.on('disable.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$(this).addClass('disabled');
				$(this).find(':input').prop('disabled', true);
			}
		});
		Page.on('toggle_enable.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				if($(this).hasClass('disabled')){
					$(this).trigger('enable.gevents', {'result':true});
				}else{
					$(this).trigger('disable.gevents', {'result':true});
				}
			}
		});

		Page.on('enable_validation.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$(this).removeClass('validationDisabled');
				$(this).find('.mainfield').addBack().each(function(Ni, Node){
					if(jQuery(Node).data('validationrules')){
						var vrules = jQuery(Node).data('validationrules');
						vrules['disabled'] = 0;
						jQuery(Node).data('validationrules', vrules);
						jQuery(Node).addClass('required');
					}
				});

				$.G3.forms.initializeForm($(this).closest('form'));
			}
		});
		Page.on('disable_validation.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$(this).addClass('validationDisabled');
				$(this).find('.mainfield').addBack().each(function(Ni, Node){
					if(jQuery(Node).data('validationrules')){
						var vrules = jQuery(Node).data('validationrules');
						vrules['disabled'] = 1;
						jQuery(Node).data('validationrules', vrules);
						
						jQuery(Node).removeClass('required error');
						jQuery(Node).find('.error-msg').remove();
					}
				});

				$.G3.forms.initializeForm($(this).closest('form'));
			}
		});
		Page.on('toggle_validation.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$(this).find('.mainfield').addBack().each(function(Ni, Node){
					if(jQuery(Node).hasClass('validationDisabled')){
						$(this).trigger('enable_validation.gevents', {'result':true});
					}else{
						$(this).trigger('disable_validation.gevents', {'result':true});
					}
				});
			}
		});

		Page.on('clear.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$(this).find(':input').not(':button, :submit, :reset, :radio, :checkbox').val('');
				$(this).find(':input:checkbox, :input:radio').prop('checked', false);
				$(this).find('select').find('option').removeAttr('selected');
				$(this).find('select').closest('.ui.dropdown').dropdown('clear');
				$(this).find(':input').trigger('change');
			}
		});
		Page.on('remove.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$(this).remove();
				$.G3.forms.initializeForm($(this).closest('form'));
			}
		});

		Page.on('checkAll.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$(this).find(':input').prop('checked', true);
			}
		});
		Page.on('uncheckAll.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$(this).find(':input').prop('checked', false);
			}
		});

		Page.on('showModal.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$(this).modal('show');
			}
		});
		Page.on('hideModal.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$(this).modal('hide');
			}
		});

		Page.on('showPopup.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$($(this).data('target')).first().popup('show');
			}
		});
		Page.on('hidePopup.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				$($(this).data('target')).first().popup('hide');
			}
		});

		Page.on('reload.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				var Node = $(this);
				if(Node.data('reload')){
					Node.addClass('ui form loading');
					var dataScope = Node.data('reload')['scope'] ? Node.closest(Node.data('reload')['scope']) : Node.closest('form.ui.form');
					
					$.ajax({
						url: Node.data('reload').url,
						data: dataScope.find(':input:not([data-cftoken])').serialize(),
						success: function(result){
							var newContent = $(result);
							
							Node.replaceWith(newContent);
							
							newContent.trigger('contentChange');
							newContent.find(':input').trigger('reload.events');
							
							jQuery.G3.forms.initializeForm(newContent.closest('form'));
						}
					});
				}
			}
		});
		Page.on('ajax.gevents', '[data-uid]', function(e, data){
			e.stopPropagation();
			if(data.result == true){
				var Node = $(this);
				if(Node.data('ajax')){
					Node.addClass('ui form loading');
					var dataScope = Node.data('ajax')['scope'] ? Node.closest(Node.data('ajax')['scope']) : Node.closest('form.ui.form');

					$.ajax({
						url: Node.data('ajax').url,
						data: dataScope.find(':input:not([data-cftoken])').serialize(),
						success: function(result){
							var newContent = $(result);
							Node.removeClass('form loading');

							if(Node.data('ajax').response == 'replace'){
								Node.replaceWith(newContent);
							}else if(Node.data('ajax').response == 'append'){
								if(Node.data('vtype') == 'area_modal'){
									Node.find('.content').append(newContent);
								}else{
									Node.append(newContent);
								}
							}else if(Node.data('ajax').response == 'prepend'){
								if(Node.data('vtype') == 'area_modal'){
									Node.find('.content').prepend(newContent);
								}else{
									Node.prepend(newContent);
								}
							}else if(Node.data('ajax').response == 'content'){
								if(Node.data('vtype') == 'area_modal'){
									Node.find('.content').html(newContent);
								}else{
									Node.html(newContent);
								}
							}else if(Node.data('ajax').response == 'after'){
								Node.after(newContent);
							}else if(Node.data('ajax').response == 'before'){
								Node.before(newContent);
							}
							
							if(Node.data('ajax').response != 'ignore'){
								newContent.trigger('contentChange');
								newContent.find(':input').trigger('ajax_success.events', {'status' : 'success'});
								
								jQuery.G3.forms.initializeForm(newContent.closest('form'));
							}
						}
					});
				}
			}
		});
	}
	
	$.G3.forms.initializeEvents = function (Page){
		// Page.find('[data-vevents]').each(function(vi, vinp){

		// });
		var exclude = [];
		if(Page.find('.clonable[data-source="1"]').length){
			exclude = Page.find('.clonable[data-source="1"]').find('*');
		}

		Page.off('change.events click.events ready.events', ':input');
		Page.on('input.events change.events click.events ready.events reload.events ajax_success.events triggers.events', ':input, [data-uid]', function(e, eData){
			// console.log(e);
			e.stopPropagation();
			var triggerdInput = this;
			// console.log('Node triggered by event: ', $(this));
			//get Field
			var triggerdField = $(this).closest('[data-uid]');
			if($(triggerdField).length == 0){
				return false;
			}
			//get Field value
			var triggerdInputValue = $.G3.forms.getVal(triggerdField);

			jQuery.each(Page.find('[data-evsources]').not(exclude), function(Li, Listener){
				if(jQuery.inArray($(triggerdField).data('uid').toString(), jQuery(Listener).data('evsources')) > -1){
					// console.log(e);
					if(e.type == 'click'){
						if(jQuery(e.currentTarget).prop('tagName') == 'A' || jQuery(e.currentTarget).prop('tagName') == 'BUTTON'){
							e.preventDefault();
						}
					}

					if(jQuery(Listener).closest('.clonable').length && $(triggerdField).closest('.clonable').length){
						if(!jQuery(Listener).closest('.clonable').is($(triggerdField).closest('.clonable'))){
							return;
						}
					}
					if($(triggerdField).data('uid').toString() == jQuery(Listener).attr('data-uid').toString()){
						if(!$(triggerdField).is(jQuery(Listener))){
							return;
						}
					}

					// console.log('Processing events for: ', jQuery(Listener));
					var events = JSON.parse(jQuery(Listener).attr('data-vevents'));

					jQuery.each(events, function(ei, event){
						
						var event_result = false;

						var conditions = event['rules'];
						var conditionsFinished = 0;
						jQuery.each(conditions, function(ci, condition){

							var conditionSource = Page.find('[data-uid="'+condition['source']+'"]').not(exclude);
							if(jQuery(Listener).closest('[data-loopid]').length){
								if(jQuery(Listener).closest('[data-loopid]').find('[data-uid="'+condition['source']+'"]').length){
									conditionSource = jQuery(Listener).closest('[data-loopid]').find('[data-uid="'+condition['source']+'"]').not(exclude);
								}
							}
							// if(conditionSource.length == 1){
							// 	conditionSource = conditionSource.first();
							// }else if(conditionSource.length > 1){
							// 	// if(jQuery(Listener).closest('.clonable').length){
							// 	// 	conditionSource = jQuery(Listener).closest('.clonable').find('[data-uid="'+condition['source']+'"]').not(exclude);
							// 	if(conditionSource.length > 1){
							// 		jQuery.each(conditionSource, function(csi, CS){
							// 			var matching_parents = jQuery(Listener).parents().filter(jQuery(CS).parents());
							// 			if(matching_parents.length > 0){
							// 				console.log(matching_parents);
							// 				conditionSource = matching_parents.first().find('[data-uid="'+condition['source']+'"]').not(exclude);
							// 				return false;
							// 			}
							// 		});
							// 	}else if($(triggerdField).data('uid').toString() == jQuery(Listener).attr('data-uid').toString()){
							// 		conditionSource = jQuery(Listener);
							// 	}
							// 	// conditionSource = conditionSource.first();
							// }
							if($(triggerdField).data('uid').toString() == jQuery(Listener).attr('data-uid').toString()){
								conditionSource = jQuery(Listener);
							}

							if(conditionSource.length == 0){
								return;
							}
							// console.log('Condition selector: ', conditionSource);
							var condition_result = $.G3.forms.testCondition(e, eData, conditionSource, condition);
							
							// console.log('Condition result: '+condition_result +' for action: '+condition['action']);

							if(condition_result == true && event['logic'] == 'or'){
								event_result = true;
								return false;
							}

							if(condition_result == false && event['logic'] == 'and'){
								return false;
							}

							conditionsFinished += 1;
							if(conditionsFinished == conditions.length && event['logic'] == 'and'){
								event_result = true;
							}
						});
						
						// console.log('Event result: '+ event_result);
						if(event['actions'] != undefined){
							$.each(event['actions'], function(Ai, Action){
								jQuery(Listener).trigger(Action+'.gevents', {'result':event_result});
							});
						}

						if(event_result == true){
							if(event['cactions'] != undefined){
								jQuery.each(event['cactions'], function(ci, Action){
									if(Action['action'] == 'value'){
										$.G3.forms.setVal(Listener, Action['p1']);
									}else if(Action['action'] == 'mvalue'){
										$.G3.forms.setVal(Listener, Action['p1m']);
									}else if(Action['action'] == 'fn'){
										if(window[Action['p1']] != undefined){
											window[Action['p1']]($.G3.forms.getInput(Listener));
										}
									}else if(Action['action'] == 'submit_form'){
										jQuery(Listener).closest('form.ui.form').submit();
									}else if(Action['action'] == 'trigger'){
										jQuery(Listener).first().trigger('triggers.events', {'name' : Action['p1']});
									}else if(Action['action'] == 'trigger_after'){
										setTimeout(function(){
											jQuery(Listener).first().trigger('triggers.events', {'name' : Action['p1']});
										}, parseInt(Action['p2']));
									}
								});
							}
						}
					});

				}
			});

		});
		
		// Page.find(':input').trigger('ready.events');
		jQuery.each(Page.find('[data-uid]').not(exclude), function(fi, Unit){
			if($(Unit).is('.mainfield')){
				$(Unit).find(':input').first().trigger('ready.events');
			}else{
				$(Unit).trigger('ready.events');
			}
		});
	}
	
	$.G3.forms.initializeFeatures = function (Form){
		Form.on('click', '.partitioned[data-sequential="1"]', function(e){
			var activeTab = jQuery(this).find('.ui.segment.tab.active').first();
			
			if(activeTab.next('.ui.segment.tab').length == 0){
				jQuery(this).find('.ui.button.forward, .ui.button.next').addClass('hidden');
				jQuery(this).find('.ui.button.finish').removeClass('hidden');
			}else{
				jQuery(this).find('.ui.button.forward, .ui.button.next').removeClass('hidden');
				jQuery(this).find('.ui.button.finish').addClass('hidden');
			}
			
			if(activeTab.prev('.ui.segment.tab').length == 0){
				jQuery(this).find('.ui.button.backward, .ui.button.prev').addClass('hidden');
			}else{
				jQuery(this).find('.ui.button.backward, .ui.button.prev').removeClass('hidden');
			}
			
			jQuery(this).find('[data-tab].active').removeClass('disabled').parent().children('[data-tab]').not('.active').addClass('disabled');
		});
		Form.find('.partitioned').trigger('click');
		
		Form.on('click', '.partitioned .ui.button.next, .partitioned .ui.button.forward', function(e){
			e.preventDefault();
			var activeTab = jQuery(this).closest('.partitioned').find('.ui.segment.tab.active').first();
			activeTab.find(':input').trigger('blur');
			
			if(activeTab.next('.ui.segment.tab').length > 0 && activeTab.find('.field.error').length == 0){
				activeTab.removeClass('active');
				jQuery('[data-tab="'+activeTab.data('tab')+'"]').removeClass('active');
				activeTab.next('.ui.segment.tab').addClass('active');
				jQuery('[data-tab="'+activeTab.next('.ui.segment.tab').data('tab')+'"]').addClass('active').removeClass('disabled');
				activeTab.trigger('click');
			}else{
				
			}
		});
		
		Form.on('click', '.partitioned .ui.button.prev, .partitioned .ui.button.backward', function(e){
			e.preventDefault();
			var activeTab = jQuery(this).closest('.partitioned').find('.ui.segment.tab.active').first();
			activeTab.find(':input').trigger('blur');
			
			if(activeTab.prev('.ui.segment.tab').length > 0){// && activeTab.find('.field.error').length == 0){
				activeTab.removeClass('active');
				jQuery('[data-tab="'+activeTab.data('tab')+'"]').removeClass('active');
				activeTab.prev('.ui.segment.tab').addClass('active');
				jQuery('[data-tab="'+activeTab.prev('.ui.segment.tab').data('tab')+'"]').addClass('active').removeClass('disabled');
				activeTab.trigger('click');
			}else{
				
			}
		});
		
		Form.on('submit', function(e){
			if(Form.form('is valid') == false){
				Form.form('validate form');//revalidate the form to have the error class added in case the error is not under the first tab
				if(Form.find('.field.error').first().is(':visible')){
					jQuery.G3.scrollTo(Form.find('.field.error').first());
				}else{
					//Form.form('validate form');//revalidate the form to have the error class added in case the error is not under the first tab
					if(Form.find('.field.error').first().closest('.partitioned').length > 0){
						var activeTab = Form.find('.field.error').first().closest('.partitioned').find('.ui.segment.tab.active').first();
			
						activeTab.removeClass('active');
						jQuery('[data-tab="'+activeTab.data('tab')+'"]').removeClass('active');
						Form.find('.field.error').first().closest('.ui.segment.tab').addClass('active');
						jQuery('[data-tab="'+Form.find('.field.error').first().closest('.ui.segment.tab').data('tab')+'"]').addClass('active');
						jQuery('[data-tab="'+Form.find('.field.error').first().closest('.ui.segment.tab').data('tab')+'"]').removeClass('disabled');
						activeTab.trigger('click');
					}
				}
			}else{
				if(Form.data('subanimation')){
					// if(Form.hasClass('childform')){
					if(Form.parent('.chronopage').length > 0 && Form.parent('.chronopage').children().length == 1){
						Form.closest('.chronopage').addClass('loading');
					}else{
						Form.addClass('loading');
					}
				}
				if(Form.find('.g-recaptcha.v3').length){
					e.preventDefault();
					grecaptcha.ready(function() {
						grecaptcha.execute(Form.find('.g-recaptcha.v3').first().data('sitekey3'), {action: 'submit'}).then(function(token) {
							Form.find('.g-recaptcha.v3').remove();
							Form.append('<input type="hidden" name="g-recaptcha-response" value="'+token+'" />');
							Form.submit();
						});
					});
				}
				if(Form.hasClass('G3-dynamic')){
					e.preventDefault();
					requestData = new FormData();
					$.each(Form.find(':input').serializeArray(), function(key, input){
						requestData.append(input.name, input.value);
					});
					Form.find('input[type="file"]').each(function(key, input){
						if($(input).prop('multiple')){
							$.each($(input).get(0).files, function(fi, File){
								requestData.append($(input).attr('name')+'['+fi+']', File);
							});
						}else{
							if($(input)[0].files.length){
								requestData.append($(input).attr('name'), $(input)[0].files[0]);
							}
						}
					});
					
					$.ajax({
						url: Form.attr('action'),
						type: "POST",
						data: requestData,
						processData: false,
						contentType: false,
						success: function(result){
							var newPage = $(result);

							if(Form.parent('.chronopage').length > 0 && Form.parent('.chronopage').children().length == 1){
								//no modal, no layout
								Form.closest('.chronopage').replaceWith(newPage);
							}else{
								//other content with form
								// newPage = $(newPage.html());
								Form.replaceWith(newPage);
							}
							
							// if(Form.hasClass('childform')){
							// 	if(newPage.find('form').length > 0){
							// 		newPage = newPage.find('form').first();
							// 	}
							// 	Form.replaceWith(newPage);
							// }else{
							// 	Form.closest('.chronopage').replaceWith(newPage);
							// }
							
							newPage.closest('.chronopage').trigger('contentChange');
							newPage.find(':input').trigger('ready.events');
						}
					});
				}
			}
		});
	}

	jQuery.G3.forms.repeater = {
		update : function(container){
			container.children('.clonable[data-group="'+container.data('group')+'"]').each(function(ic, clonable){
				$(clonable).attr('data-countindex', ic);
				$(clonable).find('[data-counting="'+container.data('match')+'"]').text(ic);
				if(container.data('mincount')){
					if(ic <= container.data('mincount')){
						$(clonable).find('.delete_clone[data-group="'+container.data('group')+'"]').addClass('hidden');
					}else{
						$(clonable).find('.delete_clone[data-group="'+container.data('group')+'"]').removeClass('hidden');
					}
				}
			});
		},

		init : function(Form){
			Form.find('.clonable_container').each(function(ci, container){
				jQuery.G3.forms.repeater.update($(container));

				if($(container).data('sortable')){
					$(container).sortable({
						items: '> .clonable',
						scroll: false,
						handle: '.sort_clone[data-group="'+$(container).data('group')+'"]',
						placeholder: 'ui segment inverted olive',
						stop: function(event, ui){
							jQuery.G3.forms.repeater.update($(container));
						},
					});
				}
			});
			
			Form.on('click', '.add_clone', function(){
				var cloning = $(this).closest('.chronopage').find('.clonable[data-group="'+$(this).data('group')+'"][data-source="1"]');
				
				var container = cloning.closest('.clonable_container[data-group="'+$(this).data('group')+'"]');
				if(container.data('maxcount')){
					if(container.find('.clonable[data-group="'+$(this).data('group')+'"]').length > container.data('maxcount')){
						return false;
					}
				}
				cloning.trigger('clone');
			});

			Form.on('clone', '.clonable', function(e){
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

				// var re_index = new RegExp('#'+group+'.index#', 'g');
				var re_index = new RegExp('#'+container.attr('data-match'), 'g');
				new_item.html(new_item.html().replace(re_index, group_index));
				// var re_count = new RegExp('#'+group+'.count#', 'g');
				// new_item.html(new_item.html().replace(re_count, group_index));

				if(!source.is('[data-source="1"]')){
					source.after(new_item);
				}else{
					container.append(new_item);
				}

				jQuery.G3.forms.repeater.update(container);
				
				new_item.trigger('contentChange', {'act':'cfw_clone_added'});
				jQuery.G3.forms.initializeForm(Form);
			});

			Form.on('click', '.delete_clone', function(){
				var container = $(this).closest('.clonable_container[data-group="'+$(this).data('group')+'"]');
				$(this).closest('.clonable').remove();

				jQuery.G3.forms.repeater.update(container);
				jQuery.G3.forms.initializeForm(Form);
			});
		},
	};
	
	$.G3.forms.invisible = function(){
		jQuery('div[data-invisible="1"]').each(function(i, invForm){
			var content = jQuery(invForm).html();
			var newForm = jQuery('<form>').html(content);
			jQuery.each(jQuery(invForm).get(0).attributes, function(i, att){
				newForm.attr(att.name, att.value);
			});
			jQuery(invForm).replaceWith(newForm);
			//jQuery('body').trigger('contentChange');
		});
	}
	
	$.G3.forms.ready = function(Page){
		jQuery.G3.forms.setupEvents(Page);

		jQuery.G3.forms.initializeEvents(Page);

		$.each(Page.find('form'), function(Fi, Form){
			jQuery.G3.forms.initializeFeatures($(Form));
		
			// jQuery.G3.forms.initializeEvents(Page);
			
			jQuery.G3.forms.initializeForm($(Form));
			
			// if(jQuery.fn.inputmask != undefined){
			// 	Form.find('[data-inputmask]').inputmask();
			// }
			
			jQuery.G3.forms.repeater.init($(Form));
		});
	}
	
}(jQuery));