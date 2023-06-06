(function($){
	if($.G3 == undefined){
		$.G3 = {};
	}
	$.G3.scrollTo = function(Elem){
		if(Elem.length > 0){
			$('html, body').animate({
				scrollTop: Elem.offset().top - 50
			}, 'slow');
		}
	};
	
	$.G3.centerOn = function(Elem){
		if(Elem.length > 0){
			$('html, body').animate({
				scrollTop: Elem.offset().top - $(window).height()/2
			}, 'slow');
		}
	};

	$.G3.copyToClipboard = function(value){
		var hidden = $('<input type="text" value="'+value+'" />');
		$("body").append(hidden);
		hidden.select();
		document.execCommand("copy");
		hidden.remove()
	};
	
	$.G3.split = function(inputs, maxcount){
		var data = {};
		if(inputs.length > maxcount){
			for(i = 0; i <= inputs.length; i = i + maxcount){
				data[i] = inputs.slice(i, i + maxcount).serialize();
			}
		}else{
			data[0] = inputs.serialize();
		}
		
		return data;
	};

	$.G3.boot = {};
	$.G3.date = {};
	
	$.G3.date.mysqltodate = function(string){
		var t = string.split(/[- :]/);
		var date = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));
		return date;
	};

	$.G3.date.format = function(date, format_string){
		var format = format_string;
		format = format.replace('YYYY', date.getFullYear());
		format = format.replace('MM', ("00" + (date.getMonth() + 1)).slice(-2));
		format = format.replace('DD', ("00" + date.getDate()).slice(-2));
		format = format.replace('HH', ("00" + date.getHours()).slice(-2));
		format = format.replace('mm', ("00" + date.getMinutes()).slice(-2));
		format = format.replace('ss', ("00" + date.getSeconds()).slice(-2));
		return format;
	};

	$.G3.boot.calendar = function(Container){
		Container.find('[data-calendar]').not('[data-g3]').attr('data-g3', 1).each(function(i, calfield){
			if(jQuery.fn.calendar != undefined){
				var dformat = $(calfield).data('dformat') ? $(calfield).data('dformat') : 'YYYY-MM-DD';
				var sformat = $(calfield).data('sformat') ? $(calfield).data('sformat') : 'YYYY-MM-DD HH:mm:ss';
				var $realDate = $(calfield).closest('.ui.calendar').next('input[type=hidden]');
				
				var mindate = null;
				if($(calfield).data('mindate')){
					var mindate = $.G3.date.mysqltodate($(calfield).data('mindate'));
				}
				var maxdate = null;
				if($(calfield).data('maxdate')){
					var maxdate = $.G3.date.mysqltodate($(calfield).data('maxdate'));
				}

				var opendays = [0,1,2,3,4,5,6];//1 for monday
				if($(calfield).data('opendays')){
					opendays = $(calfield).data('opendays').toString().split(',').map(Number);
				}
				var openhours = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];
				if($(calfield).data('openhours')){
					openhours = $(calfield).data('openhours').toString().split(',').map(Number);
				}
				
				$(calfield).closest('.ui.calendar').calendar({
					startMode : $(calfield).data('startmode'),
					type : $(calfield).data('type'),
					minDate : mindate,
					maxDate : maxdate,
					startCalendar: $(calfield).data('startcalendar') ? $('[data-uid="'+$(calfield).data('startcalendar')+'"]').first().find('.ui.calendar').first() : null,
					endCalendar: $(calfield).data('endcalendar') ? $('[data-uid="'+$(calfield).data('endcalendar')+'"]').first().find('.ui.calendar').first() : null,
					firstDayOfWeek: $(calfield).data('firstday') ? $(calfield).data('firstday') : 0,
					ampm: ($(calfield).data('ampm') != undefined) ? $(calfield).data('ampm') : true,
					monthFirst: $(calfield).data('monthfirst') ? $(calfield).data('monthfirst') : true,
					disableMinute: $(calfield).data('disableminute') ? $(calfield).data('disableminute') : false,
					inline: ($(calfield).data('inline') === 1 || $(calfield).data('inline') === 2) ? true : false, 
					
					disableMonth: $(calfield).data('disablemonth') ? $(calfield).data('disablemonth') : false,
					disableYear: $(calfield).data('disableyear') ? $(calfield).data('disableyear') : false,
					disabledDaysOfWeek: $(calfield).data('disableddaysofweek') ? $(calfield).data('disableddaysofweek').split(',') : [],

					text:{
						days: $(calfield).data('days') ? $(calfield).data('days') : ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
						months: $(calfield).data('months') ? $(calfield).data('months') : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
						monthsShort: $(calfield).data('monthsshort') ? $(calfield).data('monthsshort') : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
						today: $(calfield).data('today') ? $(calfield).data('today').split(',') : 'Today',
						now: $(calfield).data('now') ? $(calfield).data('now').split(',') : 'Now',
						am: $(calfield).data('am') ? $(calfield).data('am').split(',') : 'AM',
						pm: $(calfield).data('pm') ? $(calfield).data('pm').split(',') : 'PM'
					},
					onChange: function (date, text, mode){
						$(calfield).trigger('change.events');
					},
					formatter: {
						datetime: function (date, settings) {
							if (!date) return '';
							$realDate.val($.G3.date.format(date, sformat));
							return $.G3.date.format(date, dformat);
						},
						cell: function(cell, date, cellOptions){
							if(cellOptions.mode == 'day' && (opendays.indexOf(date.getDay()) == -1)){
								$(cell).addClass('disabled');
							}
							if(cellOptions.mode == 'hour' && (openhours.indexOf(date.getHours()) == -1)){
								$(cell).addClass('disabled');
							}
						}
					}
				});

				if($(calfield).data('inline') === 2){
					$(calfield).css('display', 'none');
				}
			}
		});
	}
	
	$.G3.boot.ready = function(){
		$('body').on('contentChange.basics', '*', function(e, settings){
			e.stopPropagation();

			var exclude = [];
			if($(this).find('.clonable[data-source="1"]').length){
				exclude = $(this).find('.clonable[data-source="1"]').find('*');
			}
			
			if($(this).prop('tagName') != 'DIV' && $(this).prop('tagName') != 'FORM'){
				//return false;
			}
			
			if(jQuery.fn.tab != undefined){
				$(this).find('.ui.menu.G3-tabs .item:not(.notab), .ui.steps.G3-tabs .step:not(.notab)').tab();
			}
			if(jQuery.fn.dropdown != undefined){
				//jQuery.fn.dropdown.settings.forceSelection = false;
				// jQuery.fn.dropdown.settings.message.addResult = '<i class="icon save"></i> <b>{term}</b>';
				$(this).find('div.ui.dropdown').each(function(di, dropmenu){
					if($(dropmenu).find('select').length == 0){
						var dsettings = {'forceSelection' : false, 'placeholder' : ''};
						if($(dropmenu).attr('data-action')){
							$.extend(dsettings, {action:$(dropmenu).attr('data-action')});
						}
						$(dropmenu).dropdown(dsettings);
					}
				});
				$(this).find('select:not(.nodropdown)').each(function(si, dropfield){
					// if($(dropfield).closest('.clonable[data-source="1"]').length){
					// 	return;
					// }
					if($(dropfield).parent('.ui.dropdown').length){
						$(dropfield).parent('.ui.dropdown').dropdown('refresh');
						return;
					}
					var dsettings = {
						'forceSelection' : false,
					};
					$.extend(dsettings, {
						'onLabelCreate':function(value, text){
							if($(dropfield).is('[data-rich]')){
								var option = $(dropfield).find('option[value="'+$(this).attr('data-value')+'"]').first();
								var opdata = option.data();
								if(opdata != undefined){
									if(opdata['icon'] != undefined){
										$(this).prepend('<i class="icon '+opdata['icon']+'"></i>');
									}
									if(opdata['iconsvg'] != undefined){
										$(this).prepend(opdata['iconsvg']);
									}
									if(opdata['tooltip'] != undefined){
										$(this).attr('data-hint', opdata['tooltip']);
									}
									if(jQuery.fn.tooltipster != undefined){
										$(this).tooltipster({
											content: $(this).data('hint'),
											maxWidth: 300,
											delay: 50,
											debug: false,
											contentAsHTML: true
										});
									}
								}
							}
							$(this).find('.icon.delete').addClass('hidden').after('<svg class="fasvg icon times link delete" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path transform="translate(80, 0)" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>');
							return this;
						}
					});
					
					if($(dropfield).is('[placeholder]')){
						var placeholder = $(dropfield).attr('placeholder');
						if(placeholder == 'false'){
							placeholder = false;
						}
						$.extend(dsettings, {'placeholder':placeholder});
					}

					if($(dropfield).is('[data-complete]')){
						$.extend(dsettings, {
							apiSettings : {
								url: $(dropfield).data('complete')['url'] + '&' + $(dropfield).attr('name') + '={query}',
								cache : false,
								onResponse : function(Response){
									if(!Response.hasOwnProperty('results')){
										var results = {};
										results['success'] = true;
										results['results'] = [];
										
										var count = 0;
										$.each(Response, function(key, obj){
											results['results'][count] = {};
											if(typeof obj === 'object'){
												results['results'][count] = obj;
												results['results'][count]['name'] = obj['name'] ? obj['name'] : obj['content'];
											}else{
												results['results'][count]['value'] = key;
												results['results'][count]['name'] = obj;
											}
											count = count + 1;
										});
										
										return results;
									}
								}
							},
							minCharacters: $(dropfield).data('completemin'),
							message : {noResults : $(dropfield).data('noresults') ? $(dropfield).data('noresults') : 'No results found'},
							//saveRemoteData:false
						});
					}
					
					if($(dropfield).attr('data-allowadditions')){
						$.extend(dsettings, {allowAdditions:true, hideAdditions: false, forceSelection: false});
					}
					
					if($(dropfield).attr('data-fulltextsearch')){
						$.extend(dsettings, {fullTextSearch: 'exact'});
					}

					if($(dropfield).attr('data-list') && $(dropfield).is('.search')){
						$.extend(dsettings, {fullTextSearch: 'exact'});
					}

					if($(dropfield).attr('data-clearable')){
						$.extend(dsettings, {clearable: true});
					}
					
					$(dropfield).dropdown(dsettings);

					if($(dropfield).attr('data-clearable') && jQuery(dropfield).closest('.ui.dropdown').length){
						jQuery(dropfield).closest('.ui.dropdown').find('.icon.remove').first().addClass('hidden').after('<svg class="fasvg icon times link remove" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path transform="translate(80, 0)" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>');
					}

					if($(dropfield).is('[data-rich]') && jQuery(dropfield).closest('.ui.dropdown').length){
						$.each(jQuery(dropfield).closest('.ui.dropdown').find('.menu').first().find('.item'), function(ti, item){
							var option = $(dropfield).find('option[value="'+$(item).attr('data-value')+'"]').first();
							var opdata = option.data();
							if(opdata != undefined){
								var icon = '';
								if(opdata['icon'] != undefined){
									icon = '<i class="icon '+opdata['icon']+'"></i>';
								}
								if(opdata['iconsvg'] != undefined){
									icon = opdata['iconsvg'];
								}
								if(opdata['label'] != undefined){
									var color = (opdata['labelcolor'] != undefined) ? 'quti text-white bg-'+opdata['labelcolor'] : '';
									$(item).prepend('<div class="ui label '+color+'">'+icon+opdata['label']+'</div>');
									icon = '';
								}else{
									$(item).removeAttr('data-text');
								}
								if(opdata['icon'] != undefined){
									$(item).prepend(icon);
								}
								if(opdata['flag'] != undefined){
									$(item).prepend('<i class="'+opdata['flag']+'"></i>');
								}
								if(opdata['html'] != undefined){
									$(item).prepend(opdata['html']);
								}
								if(opdata['category'] != undefined){
									$(item).prepend('<div class="ui label quti text-white bg-black">'+opdata['category']+'</div>');
								}
								if(opdata['type'] == 'header'){
									$(item).attr('class', 'header');
								}
								if(opdata['type'] == 'disabled'){
									$(item).attr('class', 'item disabled');
								}
								if($(option).prop('selected') && !$(dropfield).prop('multiple')){
									// selected_values.push($(option).attr('value'));
									jQuery(dropfield).closest('.ui.dropdown').find('div.text').first().html($(item).html());
								}
							}else{
								// $(item).attr('class', 'header');
								// $(option).remove();
							}
						});
					}

					if($(dropfield).is('[data-dicon]') && jQuery(dropfield).closest('.ui.dropdown').length){
						if($(dropfield).data('dicon')){

						}else{
							jQuery(dropfield).closest('.ui.dropdown').children('i').first().remove();
						}
					}

					if($(dropfield).is('[data-allowadditions]')){
						jQuery(dropfield).closest('.ui.dropdown').find('input.search').on('blur', function(e){
							if($(this).val().trim().length){
								$(dropfield).dropdown('set selected', [$(this).val().trim()]);
							}
						});
					}

					if(jQuery(dropfield).closest('.ui.dropdown.inline').length){
						jQuery(dropfield).closest('.ui.dropdown').removeClass('selection');
					}

					// if(selected_values.length && jQuery(dropfield).closest('.ui.dropdown').length){
					// 	$(dropfield).closest('.ui.dropdown').dropdown('set exactly', selected_values);
					// }
					//$(dropfield).dropdown('refresh');
				});
			}
			if(jQuery.fn.checkbox != undefined){
				$(this).find('.ui.checkbox').checkbox('refresh');
			}
			
			if(jQuery.fn.embed != undefined){
				$(this).find('.ui.embed').embed();
			}

			if(jQuery.fn.progress != undefined){
				$(this).find('.ui.progress').progress();
			}

			if(jQuery.fn.modal != undefined){
				$(this).find('.ui.modal').not(exclude).not('[data-g3]').attr('data-g3', 1).each(function(r, widget){
					$(widget).modal({
						detachable : ($(widget).attr('data-detachable')) ? true : false,
						closable : ($(widget).attr('data-closable')) ? true : false,
						observeChanges : true,
						autofocus: false,
					});
				});
			}

			if(jQuery.fn.popup != undefined){
				$(this).find('.ui.popup').not(exclude).not('[data-g3]').attr('data-g3', 1).each(function(r, widget){
					if($(widget).data('target')){
						$($(widget).data('target')).first().popup({
							popup : $(widget),
							on : ($(widget).attr('data-on')) ? $(widget).attr('data-on') : 'hover',
							hoverable : ($(widget).attr('data-hoverable')) ? true : false,
							position : ($(widget).attr('data-position')) ? $(widget).attr('data-position') : 'top left',
						});
					}
				});
			}
			
			if(jQuery.fn.sticky != undefined){
				$(this).find('.ui.sticky').sticky();
			}
			
			if(jQuery.fn.rating != undefined){
				$(this).find('.ui.rating').not(exclude).not('[data-g3]').attr('data-g3', 1).each(function(r, widget){
					var hidden = $(widget).closest('.mainfield').children(':input[type=hidden]').first();
					$(widget).attr('data-rating', hidden.val());
					
					$(widget).rating({
						onRate:function(){
							hidden.val($(this).rating('get rating'));
							hidden.trigger('change');
						},
						interactive: ($(widget).attr('data-interactive') == 1) ? true : false,
						clearable: ($(widget).attr('data-clearable') == 1) ? true : false,
					});
				});
			}
			
			if(jQuery.fn.accordion != undefined){
				$(this).find('.ui.accordion').accordion();
				$(this).find('.ui.accordion').accordion('refresh');
			}
			
			if(jQuery.fn.tooltipster != undefined){
				$(this).find('[data-hint]').addBack().each(function(i, element){
					$(element).tooltipster({
						content: $(element).data('hint'),
						maxWidth: 300,
						delay: 50,
						debug: false,
						trigger: $(element).data('hinttrigger') ? $(element).data('hinttrigger') : 'hover',
						contentAsHTML: true
					});
				});
			}
			
			if($.G3.forms != undefined){
				$.each($(this).find('.chronopage').addBack('.chronopage'), function(Fi, Page){
					$.G3.forms.ready($(Page));
				});
			}

			if($.fn.inputmask != undefined){
				$(this).find('[data-inputmask]').inputmask();
			}
			
			$.G3.boot.calendar($(this));
			
			//wysiwyg editor
			if($.G3.tinymce != undefined){
				$.G3.tinymce.init();
			}
			//textareas expand
			$.each($(this).find('textarea[data-autoresize]'), function(ti, textarea){
				$(textarea).on('input', function(){
					if($(this).data('rows') == undefined){
						$(this).data('rows', $(this).attr('rows'));
					}
					var rnum = $(this).val().split("\n").length;
					if(rnum >= parseInt($(this).attr('rows'))){
						if(rnum <= parseInt($(this).attr('data-autoresize'))){
							$(this).attr('rows', rnum);
							$(this).css('overflow', 'hidden');
						}else{
							$(this).attr('rows', parseInt($(this).attr('data-autoresize')));
							$(this).css('overflow', 'visible');
						}
					}else{
						if(parseInt($(this).attr('rows')) > $(this).data('rows')){
							if(rnum > $(this).data('rows')){
								$(this).attr('rows', rnum);
							}else{
								$(this).attr('rows', $(this).data('rows'));
							}
						}
					}
				});
			});
			
			if(typeof ace != undefined){
				$(this).find('textarea[data-codeeditor]').not(exclude).not('[data-g3]').attr('data-g3', 1).each(function(t, textarea){
					var aceeditor = $('<div class="ui code-editor"></div>');
					//$(aceeditor).css('position', 'absolute');
					$(aceeditor).css('height', parseInt($(textarea).attr('rows')) * 20);
					$(aceeditor).css('width', '100%');
					$(aceeditor).css('font-size', '14px');
					$(textarea).after(aceeditor);
					$(textarea).hide();
					
					var editor = ace.edit(aceeditor.get(0));
					//var PhpMode = ace.require("ace/mode/php").Mode;
					//editor.session.setMode(new PhpMode());
					
					editor.setValue($(textarea).val(), 1);
					
					editor.getSession().on('change', function(){
						$(textarea).val(editor.getValue());
					});
				});
			}

			$(this).find('.ui.live.button').on('click', function(e){
				e.preventDefault();

				if($(this).attr('data-url')){
					$(this).closest('form').attr('action', $(this).data('url'));
				}
				
				if($(this).attr('data-fn')){
					if(window[$(this).attr('data-fn')] != undefined){
						window[$(this).attr('data-fn')]($(this));
					}
				}else{
					if($(this).attr('data-url')){
						$(this).closest('form').submit();
					}
				}
			});
		});
		
		//toolbar
		$('.ui.toolbar-button').on('click', function(e){
			e.preventDefault();
			if($(this).attr('data-form')){
				var toolbar_form = $($(this).attr('data-form'));
			}else{
				var toolbar_form = $(this).closest('form');
			}
			
			if($(this).attr('data-url')){
				toolbar_form.attr('action', $(this).data('url'));
			}
			
			if($(this).attr('name') && $(this).attr('data-url')){
				//if the button has a url setting then use a hidden field
				toolbar_form.append($('<input />').attr('type', 'hidden').attr('name', $(this).attr('name')).val(1));
			}
			
			if($(this).data('selections') == '1' && toolbar_form.find('.ui.selector.checkbox.checked').length == 0){
				// alert($(this).data('message'));
				$('body').toast({
					class: 'error',
					message: $(this).data('message'),
					position: "top center",
				});
				return false;
			}
			
			if($(this).attr('data-fn')){
				if(window[$(this).attr('data-fn')] != undefined){
					window[$(this).attr('data-fn')]($(this));
				}
			}else{
				if($(this).attr('data-url')){
					toolbar_form.submit();
				}
			}
		});
		
		//list selectors
		if(jQuery.fn.checkbox != undefined){
			$('.ui.selector.checkbox').checkbox({
				onChecked: function(){
					$(this).closest('tr').addClass(($(this).data('selectionclass') ? $(this).data('selectionclass') : 'warning'));
				},
				onUnchecked: function(){
					$(this).closest('tr').removeClass(($(this).data('selectionclass') ? $(this).data('selectionclass') : 'warning'));
				}
			});

			$('.ui.select_all.checkbox').checkbox({
				onChecked: function(){
					$(this).closest('form').find('.ui.selector.checkbox').checkbox('check');
				},
				onUnchecked: function(){
					$(this).closest('form').find('.ui.selector.checkbox').checkbox('uncheck');
				}
			});
		}
		
		//errors
		$(':input[data-error]').closest('.field').addClass('error');
		
	};
	
}(jQuery));