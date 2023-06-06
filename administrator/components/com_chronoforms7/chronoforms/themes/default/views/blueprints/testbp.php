<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
		'title' => $this->data['Blueprint']['title'] ?? rl3('New Form'),
		'class' => 'quti bg-cfpcolor',
		'btns' => [
			[
				'color' => 'green ',
				'name' => 'apply',
				'url' => r3('index.php?ext=chronoforms&cont=blueprints&act=testbp&apply=1'),
				'hint' => rl3('Save changes and reload the editor'),
				'icon' => 'save',
				// 'title' => rl3('Create Form'),
				// 'attrs' => ['data-fn' => 'saveform']
			],
			[
				'color' => 'active inverted',
				'href' => r3('index.php?ext=chronoforms&cont=blueprints'),
				'hint' => rl3('Close'),
				'icon' => 'times',
				// 'title' => rl3('Close'),
			],
		]
	]);
?>
<?php
	\GApp3::document()->_('jquery-ui');
	// \GApp3::document()->__('keepalive');
	// \GApp3::document()->_('tinymce');
	// \GApp3::document()->_('ace');
?>
<?php
	\GApp3::document()->addJsFile(\G3\Globals::get('FRONT_URL').'vendors/blueprints/flowpad.js');

	$bp_path = \G3\Globals::get('FRONT_PATH').'vendors'.DS.'blueprints'.DS;

	$bplist = 'pages';
	$_groups = [];
	$ulist = [];

	$groups = \G3\L\Folder::getFolders($bp_path.$bplist.DS);
	foreach($groups as $group){
		$gname = basename($group);
		$sinfo_file = $group.DS.$gname.'.php';
		if(!file_exists($sinfo_file)){
			continue;
		}
		$sinfo = require($sinfo_file);
		$_groups[$gname] = $sinfo;

		$units = \G3\L\Folder::getFolders($bp_path.$bplist.DS.$gname.DS);

		foreach($units as $unit){
			$uname = basename($unit);
			$uinfo_file = $unit.DS.$uname.'.php';
			if(!file_exists($uinfo_file)){
				continue;
			}
			$uinfo = require($uinfo_file);
			$ulist[$gname][] = $uinfo;
		}
	}
?>
<div class="ui menu small inverted teal">
	<div class="right menu">
		<?php foreach($_groups as $g => $group): ?>
		<div class="ui dropdown item" data-action="nothing">
			<span class="ui text large"><?php echo $group['title']; ?></span><i class="faicon angle-down quti ml-2"></i>
			<div class="menu">
				<?php foreach($ulist[$g] as $unit): ?>
					<div class="item draggable" data-info='<?php echo json_encode($unit); ?>' data-name="<?php echo $unit['name']; ?>" data-group="<?php echo $g; ?>" data-list="<?php echo $bplist; ?>" style="padding:1px 2px !important;">
						<div class="ui button icon labeled fluid small black">
							<?php if(!empty($unit['icon'])): ?>
							<i class="faicon <?php echo $unit['icon']; ?> fitted"></i>
							<?php endif; ?>
							<?php echo $unit['title']; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endforeach; ?>
		<div class="item">
			
		</div>
	</div>
</div>


<?php //$this->view(\G3\Globals::ext_path('chronoforms', 'admin').DS.'themes'.DS.'default'.DS.'views'.DS.'designer.php'); ?>
<script>
	jQuery(document).ready(function($) {

		var config = {
			'nodes' : {
				'new' : {
					'url' : '<?php echo r3('index.php?ext=chronoforms&cont=blueprints&act=bp_unit&Blueprint[id]='.$this->data('Blueprint.id').'&tvout=view'); ?>',
				},
				'edit' : {
					'url' : '<?php echo r3('index.php?ext=chronoforms&cont=blueprints&act=bp_unit_edit&Blueprint[id]='.$this->data('Blueprint.id').'&tvout=view'); ?>',
				},
			},
			'dataout' : 'flownodes111',
			'datain' : '<?php echo $this->data('flownodes111', '{}'); ?>',
		};

		$('body').find('.draggable').flowdraggable();
		$('.flowdesigner').flowdesigner(config);

		// var flowdata = {
		// 	'nodes' : {},
		// 	'paths' : {},
		// };

		// function setPadState(pad, state){
		// 	if(state == 'ready'){
		// 		$(pad).find('.flowline.connecting').remove();
		// 		$(pad).find('.flownode-output.connecting').removeClass('connecting');
		// 		$(pad).find('.flownode-input.inactive').removeClass('inactive text-red');
		// 		$(pad).find('.flownode-input.active').removeClass('active text-green');
		// 	}
		// }

		// function updatePad(type, data){
		// 	if(type == 'add-node'){
		// 		var node = data;

		// 		flowdata['nodes'][node.data('uid')] = {
		// 			'uid' : node.data('uid'),
		// 			'name' : node.data('name'),
		// 			'group' : node.data('group'),
		// 			'list' : node.data('list'),
		// 			'offset' : {'top': parseInt($(node).css('top'), 10), 'left': parseInt($(node).css('left'), 10)},
		// 		};
		// 	}else if(type == 'remove-node'){
		// 		var node = data;

		// 		delete flowdata['nodes'][node.data('uid')];
		// 	}else if(type == 'add-path'){
		// 		var from = data['from'];
		// 		var to = data['to'];

		// 		flowdata['paths'][from] = {
		// 			'from' : from,
		// 			'to' : to,
		// 		};
		// 	}else if(type == 'remove-path'){
		// 		var from = data;

		// 		delete flowdata['paths'][from];
		// 	}

		// 	console.log(flowdata);
		// }

		// function getSVG(content, sclass){
		// 	if(!sclass){
		// 		sclass = '';
		// 	}
		// 	return $('<svg style="position:absolute;left:0;top:0;width:100%;height:100%;z-index:9999;pointer-events:none;" class="flowdraw '+sclass+'">'+content+'</svg>');
		// }

		// function getPoint(node, dir){
		// 	var x = $(node).offset().left - $(node).closest('.flowpad').offset().left;
		// 	var y = $(node).offset().top - $(node).closest('.flowpad').offset().top;

		// 	x = x + ((dir == 'to') ? $(node).outerWidth()/5 : $(node).outerWidth()/1.2);
		// 	y = y + $(node).outerHeight()/2;

		// 	return {'x': x, 'y': y};
		// }

		// function drawLine(from, to){
		// 	var x1 = getPoint(from, 'from').x;
		// 	var y1 = getPoint(from, 'from').y;

		// 	var x2 = to.x;
		// 	var y2 = to.y;

		// 	var line = $('<line x1="'+x1+'" y1="'+y1+'" x2="'+x2+'" y2="'+y2+'"/>');

		// 	$.each(config['lines']['connecting'], function(pk, pv){
		// 		line.attr(pk, pv);
		// 	});

		// 	var area = getSVG($(line).prop('outerHTML'), 'flowline connecting');

		// 	$(from).closest('.flowpad').append(area);
		// }

		// function removeLine(node){
		// 	$(node).closest('.flowpad').find('.flowline.connected line[data-from="'+$(node).data('uid')+'"]').closest('.flowline.connected').remove();
		// 	$(node).closest('.flowpad').find('.flowline.connected line[data-to="'+$(node).data('uid')+'"]').closest('.flowline.connected').remove();
		// }

		// function drawPath(from, to){
		// 	var x1 = getPoint(from, 'from').x;
		// 	var y1 = getPoint(from, 'from').y;

		// 	var x1c = x1 + 120;
		// 	var y1c = y1;

		// 	var x2 = getPoint(to, 'to').x;
		// 	var y2 = getPoint(to, 'to').y;

		// 	var x2c = x2 - 120;
		// 	var y2c = y2;
			
		// 	var path = $('<path fill="none" d="M'+x1+','+y1+' C'+x1c+','+y1c+' '+x2c+','+y2c+' '+x2+','+y2+'" data-from="'+from.data('uid')+'" data-to="'+to.data('uid')+'"/>');

		// 	$.each(config['lines']['connected'], function(pk, pv){
		// 		path.attr(pk, pv);
		// 	});

		// 	var area = getSVG($(path).prop('outerHTML'), 'flowline connected');

		// 	$(from).closest('.flowpad').append(area);

		// 	updatePad('add-path', {'from': $(from).data('uid'), 'to': $(to).data('uid')});
		// }

		// function removePath(path){
		// 	updatePad('remove-path', $(path).data('from'));
		// 	$(path).closest('.flowline').remove();
		// }

		// function removeNodeConnections(node){
		// 	removePath($(node).closest('.flowpad').find('.flowline.connected path[data-from="'+$(node).data('uid')+'"]').first());
		// 	removePath($(node).closest('.flowpad').find('.flowline.connected path[data-to="'+$(node).data('uid')+'"]').first());
		// }

		// function addNode(flownode, offset){
		// 	flownode.css('position', 'absolute');

		// 	flownode.trigger('flowpad.make.movable');

		// 	$(flownode).offset(offset);

		// 	$('#flownodes-count').val(parseInt($('#flownodes-count').val()) + 1);

		// 	updatePad('add-node', flownode);
		// }

		// function removeNode(flownode){
		// 	var pad = $(flownode).closest('.flowpad');

		// 	var toLines = pad.find('.flowline.connected path[data-to^="'+flownode.data('uid')+'/"]');
				
		// 	$(toLines).each(function(Li, Line){
		// 		removePath(Line);
		// 	});

		// 	var fromLines = pad.find('.flowline.connected path[data-from^="'+flownode.data('uid')+'/"]');
			
		// 	$(fromLines).each(function(Li, Line){
		// 		removePath(Line);
		// 	});

		// 	if(flownode.closest('.flowform').find('#flownode-config-'+flownode.data('uid')).length){
		// 		flownode.closest('.flowform').find('#flownode-config-'+flownode.data('uid')).remove();
		// 	}

		// 	updatePad('remove-node', flownode);

		// 	flownode.remove();
		// }

		// $('body').on('flowpad.make.draggable', '.draggable', function(e){
		// 	$(this).draggable({
		// 		'helper' : 'clone',
		// 		appendTo: 'body',
		// 		//'revert' : 'invalid',
		// 		connectToSortable: '.draggable-receiver:not(.drop_disabled)',
		// 		start: function(e, ui){
		// 			$(ui.helper).find('.button').css('z-index', 999999);
		// 			$(ui.helper).find('.button').css('min-width', '200px');
		// 			$(ui.helper).find('.button').addClass('ui button orange quti bg-grey700 text-white');
		// 		}
		// 	});
		// });
		// $('body').find('.draggable').trigger('flowpad.make.draggable');
		
		// $('body').on('flowpad.make.droppable', '.flowpad', initFlowPad);
		// $('body').find('.flowpad').trigger('flowpad.make.droppable');

		// function initFlowPad(e){
		// 	e.stopPropagation();

		// 	var pad = $(this);

		// 	pad.droppable({
		// 		drop: function(event, ui){
		// 			var draggable = $(ui.helper);
		// 			if($(draggable).data('info')){
		// 				$(draggable).css('width', '');
						
		// 				drop($(ui.helper), pad, ui.offset);
		// 			}
		// 		},
		// 	});
		// }
		
		// function drop(draggable, droppable, offset){
		// 	var dropInfo = draggable.data('info');
		// 	var type = dropInfo.name;
			
		// 	$.ajax({
		// 		url: config['nodes']['new']['url'],
		// 		data: {'count' : $('#flownodes-count').val(), 'name' : $(draggable).data('name'), 'group' : $(draggable).data('group'), 'list' : $(draggable).data('list')},
		// 		success: function(result){
		// 			var newFlowNode = $(result);
					
		// 			droppable.append(newFlowNode);

		// 			addNode($(newFlowNode), offset);
		// 		}
		// 	});
		// }

		// $('body').on('flowpad.make.movable', '.flownode', function(e){
		// 	var flownode = $(this);

		// 	$(this).draggable({
		// 		containment: 'parent',
		// 		handle: '.flownode-header',
		// 		scroll: true,
		// 		scrollSpeed:50,
		// 		start: function(event, ui){
		// 			flownode.closest('.flowpad').append(flownode);
		// 		},
		// 		stop: function(event, ui){
		// 			updatePad('add-node', flownode);
		// 		},
		// 		drag: function(event, ui){
		// 			var pad = flownode.closest('.flowpad');

		// 			var toLines = pad.find('.flowline.connected path[data-to^="'+flownode.data('uid')+'/"]');
					
		// 			$(toLines).each(function(Li, Line){
		// 				var NodeInput = flownode.find('.flownode-input[data-uid="'+$(Line).data('to')+'"]').first();
						
		// 				removePath(Line);

		// 				var OtherNodeOutput = pad.find('.flownode-output[data-uid="'+$(Line).data('from')+'"]');
		// 				drawPath(OtherNodeOutput, NodeInput);
		// 			});

		// 			var fromLines = pad.find('.flowline.connected path[data-from^="'+flownode.data('uid')+'/"]');
					
		// 			$(fromLines).each(function(Li, Line){
		// 				var NodeOutput = flownode.find('.flownode-output[data-uid="'+$(Line).data('from')+'"]').first();
						
		// 				removePath(Line);

		// 				var OtherNodeInput = pad.find('.flownode-input[data-uid="'+$(Line).data('to')+'"]');
		// 				drawPath(NodeOutput, OtherNodeInput);
		// 			});
		// 		},
		// 	});
		// });

		// $('body').find('.flownode').trigger('flowpad.make.movable');

		// $('body').on('click', '.flownode-delete', function(e){
		// 	e.stopPropagation();
		// 	e.preventDefault();

		// 	var flownode = $(this).closest('.flownode');

		// 	removeNode(flownode);
		// });

		// $('body').on('click', '.flownode-edit', function(e){
		// 	e.stopPropagation();
		// 	e.preventDefault();

		// 	var node = $(this).closest('.flownode');

		// 	if($('#flownode-config-'+$(node).data('uid')).length){
		// 		$(node).closest('.flowform').find('.flowconfig').children().addClass('hidden');
		// 		$('#flownode-config-'+$(node).data('uid')).removeClass('hidden');
		// 	}else{
		// 		$.ajax({
		// 			url: config['nodes']['edit']['url'],
		// 			data: {'uid' : $(node).data('uid'), 'name' : $(node).data('name'), 'group' : $(node).data('group'), 'list' : $(node).data('list')},
		// 			success: function(result){
		// 				var flowNodeConfig = $(result);
						
		// 				$(node).closest('.flowform').find('.flowconfig').children().addClass('hidden');
		// 				$(node).closest('.flowform').find('.flowconfig').first().append(flowNodeConfig);

		// 				flowNodeConfig.trigger('contentChange.basics');
		// 			}
		// 		});
		// 	}
		// });


		// $('body').on('mousedown', '.flownode-output', function(e){
		// 	e.stopPropagation();
		// 	e.preventDefault();
		// 	$(this).addClass('connecting');

		// 	var x2 = e.pageX - $(this).closest('.flowpad').offset().left;
		// 	var y2 = e.pageY - $(this).closest('.flowpad').offset().top;

		// 	drawLine($(this), {'x': x2, 'y': y2});

		// 	$(this).closest('.flowpad').find('.flownode-input[data-type="'+$(this).data('type')+'"]').addClass('active text-green');

		// 	$(this).closest('.flownode').find('.flownode-input').removeClass('active text-green').addClass('inactive text-red');
		// 	$(this).closest('.flowpad').find('.flownode-input[data-type!="'+$(this).data('type')+'"]').addClass('inactive text-red');
		// });

		// $('body').on('mouseup', '.flownode-input', function(e){
		// 	e.stopPropagation();
		// 	if($(this).closest('.flowpad').find('.flownode-output.connecting').length){
		// 		var output = $(this).closest('.flowpad').find('.flownode-output.connecting').first();

		// 		if(!$(this).closest('.flownode').is($(output).closest('.flownode'))){
		// 			var info = JSON.parse($(this).attr('data-info'));
		// 			var outinfo = JSON.parse($(output).attr('data-info'));

		// 			if(info['type'] == outinfo['type']){
		// 				removeNodeConnections($(this));
		// 				removeNodeConnections($(output));

		// 				drawPath($(output), $(this));

		// 				setPadState($(this).closest('.flowpad'), 'ready');
		// 			}
		// 		}
		// 	}else{
		// 		removeLine($(this));
		// 	}
		// });

		// $('body').on('click', '.flowpad', function(e){
		// 	if($(this).find('.flownode-output.connecting').length){
		// 		setPadState($(this), 'ready');
		// 	}
		// });

		// $('body').on('mousemove', function(e){
		// 	if($('.flowline.connecting').length){
		// 		var markArea = $('.flowline.connecting').first();
		// 		var markLine = $('.flowline.connecting').first().find('line').first();

		// 		$(markLine).attr('x2', e.pageX - $(markArea).closest('.flowpad').offset().left).attr('y2', e.pageY - $(markArea).closest('.flowpad').offset().top);
		// 	}
		// });
	});
</script>

<div class="flowdesigner ui form">
	<input type="hidden" class="flownodes-count" value="<?php echo !empty($flownodes) ? max(array_keys($flownodes)) + 1 : 1; ?>" />

	<div class="ui segment flowpad" style="min-height:500px;overflow:scroll;">
		<?php
			if(!empty($flownodes)){
				foreach($flownodes as $uid => $flownode){
					$this->view('views.blueprints.bp_unit', ['uid' => $uid, 'flownode' => $flownode, 'bp_path' => $bp_path]);
				}
			}
		?>
	</div>

	<div class="flowconfig">

	</div>
</div>
<!-- <svg>
    <line x1="5" y1="5" x2="100" y2="100" stroke="#765373" stroke-width="8"/>
	<path stroke-width="10" fill="none" d="M175,73.5 C248.5,73.5 247.5,123 322,123" stroke="#3366ff"></path>
</svg> -->
<div class="ui checkbox hidden table"></div>
<div class="quti hidden text-ml text-red text-green p-1 text-yellow text-orange text-white cursor-pointer cursor-move bg-blue700"></div>
