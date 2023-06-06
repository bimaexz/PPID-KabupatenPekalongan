<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\A\E\Chronoforms\H;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Field extends \G3\L\Helper{
	//var $tooltip_loaded = false;
	
	function setup($unit, $_map = [], $input = 'main'){
		// $unit = $this->controller->Behaviors->apply('before_view_build', $unit);

		$nodes = [];
		//$this->get('cf_settings.tooltip.class', 'quti bg-blue text-white rounded-1 p-1 ml-1')
		$nodes['tooltip'] = ['name' => 'tooltip', 'tag' => 'span', 'content' => '<i class="faicon question"></i>', 'attrs' => ['class' => 'quti bg-blue text-white rounded-1 p-1 mx-1']];
		$nodes['label'] = ['name' => 'label', 'tag' => 'label'];
		$nodes['main'] = ['name' => 'main', 'tag' => 'input', 'active' => true];
		$nodes['icon'] = ['name' => 'icon', 'tag' => 'i', 'content' => '', 'attrs' => ['class' => ['faicon']]];
		$nodes['help'] = ['name' => 'help', 'tag' => 'small', 'attrs' => ['style' => ['display:block;']]];
		$nodes['input'] = ['name' => 'input', 'tag' => 'div', 'attrs' => ['class' => ['ui input icon']]];
		$nodes['checkbox'] = ['name' => 'checkbox', 'tag' => 'div', 'content' => '', 'attrs' => ['class' => ['ui checkbox']]];
		$nodes['container'] = ['name' => 'container', 'tag' => 'div', 'active' => true, 'attrs' => ['class' => ['mainfield field']]];

		// foreach($nodes as $name => $node){
		// 	if(!empty($unit['nodes'][$name])){
		// 		$nodes[$name] = array_replace_recursive($nodes[$name], $unit['nodes'][$name]);
		// 	}
		// }
		// //add special view nodes
		// foreach($unit['nodes'] as $name => $node){
		// 	if(empty($nodes[$name])){
		// 		$nodes[$name] = $unit['nodes'][$name];
		// 	}
		// }

		if(empty($_map)){
			$_map = [
				'label' => ['children' => ['tooltip']],
				'input' => ['children' => ['main', 'icon']],
				'checkbox' => ['children' => ['label', 'input', 'help']],
				'container' => ['children' => ['checkbox']],
			];
		}
		// $input = 'main';
		// foreach($_map as $name => $node){
		// 	if(!empty($node['input'])){
		// 		$input = $name;
		// 	}
		// }

		$map_keys = array_keys($_map);
		$container = array_pop($map_keys);
		// while(isset($_map[$container]['active']) AND $_map[$container]['active'] === false){
		// 	$container = array_pop($map_keys);
		// }

		if(empty($unit['nodes'])){
			$unit['nodes'] = [];
		}

		// $unit = $this->controller->Behaviors->apply('before_view_build', $unit, ['input' => $input, 'container' => $container]);
		
		$nodes = array_replace_recursive($_map, $nodes, $unit['nodes'], $_map);
		// pr($nodes);
		$unit['nodes'] = &$nodes;
		// if(!empty($unit['_repeaters'])){
		// 	foreach($unit['_repeaters'] as $ruid){
		// 		$repeater = $this->controller->FData->cdata('views.'.$ruid);
				
		// 		if(!empty($unit['nodes'][$input]['attrs']['name'])){
		// 			$unit['nodes'][$input]['attrs']['name'] = $repeater['model'].'[#'.$repeater['name'].'.index#]'.'['.$unit['nodes'][$input]['attrs']['name'].']';
		// 			// $unit['nodes'][$input]['attrs']['id'] = $repeater['model'].'_#'.$repeater['name'].'.index#'.'_'.$unit['nodes'][$input]['attrs']['id'];

		// 			if($this->get($repeater['name'].'.source')){
		// 				$unit['nodes'][$input]['attrs']['disabled'] = 'disabled';
		// 			}
		// 		}

		// 		foreach($unit['nodes'] as $node_name => $node){
		// 			if(!empty($unit['nodes'][$node_name]['attrs'])){
		// 				foreach($unit['nodes'][$node_name]['attrs'] as $attr => $value){
		// 					if(!is_null($this->get($repeater['name'].'.index'))){
		// 						$value = str_replace('#'.$repeater['name'].'.index#', $this->get($repeater['name'].'.index'), $value);
		// 					}
		// 					if(!is_null($this->get($repeater['name'].'.count'))){
		// 						$value = str_replace('#'.$repeater['name'].'.count#', $this->get($repeater['name'].'.count'), $value);
		// 					}

		// 					$unit['nodes'][$node_name]['attrs'][$attr] = $value;
		// 				}
		// 			}
		// 			if(!empty($unit['nodes'][$node_name]['content'])){
		// 				if(!is_null($this->get($repeater['name'].'.index'))){
		// 					$unit['nodes'][$node_name]['content'] = str_replace('#'.$repeater['name'].'.index#', $this->get($repeater['name'].'.index'), $unit['nodes'][$node_name]['content']);
		// 				}
		// 				if(!is_null($this->get($repeater['name'].'.count'))){
		// 					$unit['nodes'][$node_name]['content'] = str_replace('#'.$repeater['name'].'.count#', $this->get($repeater['name'].'.count'), $unit['nodes'][$node_name]['content']);
		// 				}
		// 			}
		// 		}
		// 	}
		// }
		
		if(!empty($this->get('__loops', []))){
			foreach($this->get('__loops', []) as $loop_name => $loop_index){
				if(is_numeric($loop_index)){
					foreach($unit['nodes'] as $node_name => $node){
						if(!empty($unit['nodes'][$node_name]['attrs'])){
							foreach($unit['nodes'][$node_name]['attrs'] as $attr => $value){
								$value = str_replace('#'.$loop_name, $loop_index, $value);
	
								$unit['nodes'][$node_name]['attrs'][$attr] = $value;
							}
						}
						if(!empty($unit['nodes'][$node_name]['content'])){
							$unit['nodes'][$node_name]['content'] = str_replace('#'.$loop_name, $loop_index, $unit['nodes'][$node_name]['content']);
							$unit['nodes'][$node_name]['content'] = str_replace('@'.$loop_name, '<span data-counting="'.$loop_name.'">'.$this->get('__loops_counts.'.$loop_name, 0).'</span>', $unit['nodes'][$node_name]['content']);
						}
					}
				}else if($loop_index == '#'.$loop_name){
					if(strpos($unit['type'], 'area_') === false){
						$unit['nodes'][$input]['attrs']['disabled'] = 'disabled';

						foreach($unit['nodes'] as $node_name => $node){
							if(!empty($unit['nodes'][$node_name]['content'])){
								$unit['nodes'][$node_name]['content'] = str_replace('@'.$loop_name, '<span data-counting="'.$loop_name.'">'.$loop_index.'</span>', $unit['nodes'][$node_name]['content']);
							}
						}
					}
				}
			}
		}

		if(!empty($unit['nodes'][$input]['attrs']['name']) AND strpos($unit['nodes'][$input]['attrs']['name'], '.') !== false){
			$multi = false;
			if(strpos($unit['nodes'][$input]['attrs']['name'], '[]') !== false){
				$multi = true;
				$unit['nodes'][$input]['attrs']['name'] = str_replace('[]', '', $unit['nodes'][$input]['attrs']['name']);
			}
			$npcs = explode('.', $unit['nodes'][$input]['attrs']['name']);
			$n1 = array_shift($npcs);
			$unit['nodes'][$input]['attrs']['name'] = $n1.'['.implode('][', $npcs).']';
			if($multi){
				$unit['nodes'][$input]['attrs']['name'] .= '[]';
			}
		}

		if(!isset($unit['nodes'][$input]['attrs']['id']) AND isset($unit['nodes'][$input]['attrs']['name'])){
			if(!empty($unit['nodes'][$input]['counter'])){
				//for field checkboxes/radios
				$unit['nodes'][$input]['attrs']['id'] = $this->viewer->Parser->ID($unit['nodes'][$input]['attrs']['name'].'_'.$unit['nodes'][$input]['counter']);
			}else{
				$unit['nodes'][$input]['attrs']['id'] = $this->viewer->Parser->ID($unit['nodes'][$input]['attrs']['name']);
			}
		}

		$unit = $this->controller->Behaviors->apply('before_view_build', $unit, ['input' => $input, 'container' => $container, '_local' => true]);
		
		// $this->setAttrs($unit, $nodes[$input]);
		//apply changes
		foreach($nodes as $name => $node){
			if(!empty($nodes[$name]['attrs'])){
				foreach($nodes[$name]['attrs'] as $pkey => $pvalue){
					if(is_string($pvalue)){
						if(strlen($pvalue)){
							$nodes[$name]['attrs'][$pkey] = $this->viewer->Parser->parse($pvalue);
						}
						if(empty($nodes[$name]['attrs'][$pkey]) AND strlen($nodes[$name]['attrs'][$pkey]) == 0){
							unset($nodes[$name]['attrs'][$pkey]);
						}
					}
				}
			}
			if(isset($nodes[$name]['content'])){
				$nodes[$name]['content'] = $this->viewer->Parser->parse($nodes[$name]['content']);
			}
		}
		
		// if(!empty($unit['validation']) AND !isset($nodes[$container]['inner'])){
		// 	// $signed = $this->setValidations($unit, $nodes[$input], $nodes[$container]);
		// 	// if($signed){
		// 	// 	$nodes[$container]['attrs']['class']['required'] = 'required';
		// 	// }
		// }

		if(isset($nodes['label']['content']) AND strlen($nodes['label']['content']) > 0){
			$nodes['label']['active'] = true;
			if(strlen(trim($nodes['label']['content'])) == 0){
				$nodes['label']['content'] = '&nbsp;';
			}
			if(!empty($nodes[$input]['attrs']['id'])){
				$nodes['label']['attrs']['for'] = $nodes[$input]['attrs']['id'];
			}
		}
		
		// if(!empty($nodes['main']['attrs']['data-reload'])){
		// 	$nodes[$container]['attrs']['data-reload'] = r3($this->viewer->Parser->_url().rp3('event', $nodes['main']['attrs']['data-reload']).rp3('uid', $unit['uid']).rp3('tvout', 'view'));
		// 	// unset($nodes['main']['attrs']['data-reload']);
		// }

		// if(!empty($nodes[$input]['attrs']['multiple']) OR ($unit['type'] == 'field_checkboxes')){
		// 	if(substr($nodes[$input]['attrs']['name'], -2) != '[]'){
		// 		//$nodes[$input]['attrs']['name'] .= '[]';
		// 	}
		// }

		// if(!empty($unit['vevents']) AND !isset($nodes[$container]['inner'])){
		// 	// $this->setVEvents($unit, $nodes[$container]);
		// }

		if(!isset($nodes[$container]['inner'])){
			$nodes[$container]['attrs']['data-vtype'] = str_replace(['field_', 'wfield_'], '', $unit['type']);
			$nodes[$container]['attrs']['data-uid'] = $unit['uid'];

			if(strpos($unit['type'], 'field_') !== false OR strpos($unit['type'], 'wfield_') !== false){
				$nodes[$container]['attrs']['data-isinput'] = 1;
			}
		}

		if($nodes[$input]['tag'] == 'input' AND empty($nodes[$input]['attrs']['type']) AND strpos($unit['type'], 'field_') === 0){
			$nodes[$input]['attrs']['type'] = str_replace('field_', '', $unit['type']);
		}

		$this->setAttrs($unit, $nodes[$input]);

		// pr($nodes);
		
		foreach($nodes as $name => $node){
			if(!empty($node['children'])){
				foreach($node['children'] as $ck => $child){
					if(is_string($child)){
						if(isset($nodes[$child])){
							$nodes[$name]['children'][$ck] = $nodes[$child];
						}else if($child == '__CONTENT__'){
							$nodes[$name]['children'][$ck] = $nodes[$name]['content'];
							$nodes[$name]['content'] = '';
						}
					}else{
						//$nodes[$name]['children'][] = $child;
					}
				}
			}
		}

		// pr($nodes);

		return $this->viewer->Html->node($nodes[$container]);
	}

	function build($unit, $map = [], $input = 'main'){

		// if(in_array($unit['type'], ['field_text', 'field_password', 'field_textarea'])){
		// 	if(!empty($unit['nodes']['icon']['active'])){
		// 		$unit['nodes']['input']['active'] = true;
		// 	}
		// }

		$unit = $this->prepare($unit, $input);

		return $this->setup($unit, $map, $input);
	}

	function prepare($unit, $input = 'main'){
		if(in_array($unit['type'], ['field_text', 'field_password', 'field_textarea'])){
			if(!empty($unit['nodes']['icon']['active'])){
				$unit['nodes']['input']['active'] = true;
			}
		}

		// if(!isset($unit['nodes'][$input]['attrs']['id']) AND isset($unit['nodes'][$input]['attrs']['name'])){
		// 	$unit['nodes'][$input]['attrs']['id'] = \G3\L\Str::slug($unit['nodes'][$input]['attrs']['name'], '_');
		// }
		return $unit;
	}

	function buildCalendar($unit){
		$unit = $this->prepare($unit);

		if(empty($unit['calendar']['inline'])){
			$unit['nodes']['input']['active'] = true;
			$unit['nodes']['icon']['active'] = true;
			$unit['nodes']['icon']['attrs']['class']['calendar'] = 'calendar';
		}

		$unit['nodes']['main']['attrs']['data-calendar'] = '1';
		$unit['nodes']['main']['attrs']['autocomplete'] = 'off';

		$unit['nodes']['calendar']['active'] = true;
		$unit['nodes']['calendar']['attrs']['class']['calendar'] = 'ui calendar';

		$unit['nodes']['calendar']['after'][] = ['active' => true, 'tag' => 'input', 'attrs' => ['type' => 'hidden', 'data-real' => 1, 'name' => $unit['nodes']['main']['attrs']['name']]];

		$unit['calendar'] = $unit['calendar'] ?? [];
		foreach($unit['calendar'] as $k => $v){
			if(is_array($v)){
				$v = json_encode($v);
			}else{
				$v = $this->viewer->Parser->parse($v);
			}
			if($k == 'related' AND !empty($unit['calendar']['relation'])){
				$k = $unit['calendar']['relation'].'calendar';
				$other_unit = $this->controller->FData->cdata('views.'.$v);
				//$v = '#'.$other_unit['nodes']['main']['attrs']['id'];
			}
			if($k == 'mindate' OR $k == 'maxdate'){
				if(!empty($v)){
					$v = date('Y-m-d H:i:s', strtotime($v));
				}else{
					continue;
				}
			}
			
			$unit['nodes']['main']['attrs']['data-'.$k] = $v;
		}

		$_map = [
			'label' => ['children' => ['tooltip']],
			'input' => ['children' => ['main', 'icon']],
			'calendar' => ['children' => ['input']],
			'checkbox' => ['children' => ['label', 'calendar', 'help']],
			'container' => ['children' => ['checkbox']],
		];
		
		return $this->setup($unit, $_map);
	}

	function buildFile($unit){
		$unit = $this->prepare($unit);

		$extensions = $unit['fns']['upload']['fields'][$unit['uid']]['extensions'] ?? $this->get('cf_settings.upload.extensions', []);
		array_walk($extensions, function(&$v){
			$v = '.'.ltrim($v, '.');
		});
		
		$unit['nodes']['main']['attrs']['accept'][] = implode(',', $extensions);
		// $unit['nodes']['container']['attrs']['data-url'] = \G3\L\Url::build(\G3\L\Url::current(), array_merge(['event' => '_qupload_', 'tvout' => 'view']));
		
		return $this->setup($unit);
	}

	function buildButton($unit){
		$unit = $this->prepare($unit);
		if(0){
		// 	$unit['nodes']['main']['attrs']['type'] = 'button';
		// 	$unit['nodes']['main']['attrs']['class']['repeater'] = 'add_clone';
		// 	if(!empty($unit['_repeaters'])){
		// 		$repeaters = $unit['_repeaters'];
		// 		$ruid = array_pop($repeaters);
		// 		$repeater = $this->controller->FData->cdata('views.'.$ruid);
		// 		$unit['nodes']['main']['attrs']['data-cloning'] = 'copy';
		// 		$unit['nodes']['main']['attrs']['data-group'] = $repeater['model'];
		// 	}
		// }else if($unit['nodes']['main']['attrs']['type'] == 'repeater_remove'){
		// 	$unit['nodes']['main']['attrs']['type'] = 'button';
		// 	$unit['nodes']['main']['attrs']['class']['repeater'] = 'delete_clone';
		// 	if(!empty($unit['_repeaters'])){
		// 		$repeaters = $unit['_repeaters'];
		// 		$ruid = array_pop($repeaters);
		// 		$repeater = $this->controller->FData->cdata('views.'.$ruid);
		// 		$unit['nodes']['main']['attrs']['data-group'] = $repeater['name'];
		// 	}

		// }else if($unit['nodes']['main']['attrs']['type'] == 'partitions_forward'){
		// 	$unit['nodes']['main']['attrs']['type'] = 'button';
		// 	$unit['nodes']['main']['attrs']['class'][] = 'forward';
		// }else if($unit['nodes']['main']['attrs']['type'] == 'partitions_backward'){
		// 	$unit['nodes']['main']['attrs']['type'] = 'button';
		// 	$unit['nodes']['main']['attrs']['class'][] = 'backward';
		// }else if($unit['nodes']['main']['attrs']['type'] == 'partitions_finish'){
		// 	$unit['nodes']['main']['attrs']['type'] = 'button';
		// 	$unit['nodes']['main']['attrs']['class'][] = 'finish';
		// }else if($unit['nodes']['main']['attrs']['type'] == 'toolbar'){
		// 	$unit['nodes']['main']['attrs']['type'] = 'submit';
		// 	$unit['nodes']['main']['attrs']['class'][] = 'toolbar-button';
		}

		if($unit['nodes']['main']['attrs']['type'] == 'clear'){
			$unit['nodes']['main']['attrs']['type'] = 'button';
			$unit['nodes']['main']['attrs']['data-clear'] = '1';
		}
	
		$unit['nodes']['main']['attrs']['class']['default'] = 'ui button';

		if(!empty($unit['nodes']['icon']['active'])){
			$unit['nodes']['main']['attrs']['class']['icon'] = 'icon';
			// if(!isset($unit['nodes']['main']['attrs']['class']['labeled'])){
			// 	$unit['nodes']['main']['attrs']['class']['labeled'] = 'left labeled';
			// }
		}
	
		$unit['nodes']['main']['tag'] = 'button';
		// if($unit['nodes']['main']['attrs']['type'] == 'link'){
		// 	$unit['nodes']['main']['tag'] = 'a';
		// }
	
		$_map = [
			'main' => ['children' => ['icon']],
			'container' => ['children' => ['label', 'main', 'help']],
		];

		return $this->setup($unit, $_map);
	}

	function buildSelect($unit){
		$unit = $this->prepare($unit);
		$unit['nodes']['main']['tag'] = 'select';
		$unit['nodes']['main']['content'] = '';

		// if(!empty($unit['autocomplete']['event'])){
		// 	$unit['nodes']['main']['attrs']['data-completeurl'] = r3($this->controller->Parser->_url().rp3('event', $unit['autocomplete']).rp3('tvout', 'view'));
		// }

		if(!empty($unit['columns'])){
			$columns_class = [
				2 => 'two columns',
				3 => 'three columns',
				4 => 'four columns',
				5 => 'five columns',
				6 => 'six columns',
				7 => 'seven columns',
			];
			$unit['nodes']['main']['attrs']['class'][] = $columns_class[$unit['columns']];
		}

		// $options = $this->controller->Parser->options($unit['options']);
		if(!empty($unit['foptions'])){
			foreach($unit['foptions'] as $value => $option){
				$unit['nodes']['main']['children'][] = [
					'active' => true,
					'tag' => 'option',
					'content' => $option['content'],
					'attrs' => $option,
				];
			}
			$unit['nodes']['main']['attrs']['data-rich'] = '1';
		}

		return $this->setup($unit);
	}

	function buildMulti($unit, $type){
		$unit = $this->prepare($unit);

		if(empty($unit['nodes']['checkbox']['attrs']['class']['style'])){
			$unit['nodes']['checkbox']['attrs']['class']['style'] = $type;
		}

		$subfields = [];

		if(!empty($unit['foptions'])){
			// $options = $this->controller->Parser->options($unit['options']);
			$counter = 1;
			foreach($unit['foptions'] as $value => $option){
				$label = $option['content'];
				unset($option['content']);
				$submap = [
					'label' => ['content' => $label],
					'main' => ['counter' => $counter, 'attrs' => ['type' => $type, 'value' => $option['value']] + $option],
					'checkbox' => ['active' => true, 'children' => ['main', 'label'], 'attrs' => ['class' => ['ui checkbox'], 'style' => 'margin:0;']],
					'subcontainer' => ['inner' => true, 'active' => true, 'children' => ['checkbox'], 'attrs' => ['class' => ['field']]],
				];
				
				$subfields[] = $this->setup($unit, $submap);
				$counter++;
			}

			if(empty($unit['nodes']['container']['attrs']['class']['layout'])){
				$unit['nodes']['container']['attrs']['class']['layout'] = 'grouped fields';
			}

			if(!empty($unit['columns']) AND (int)$unit['columns'] > 1){
				$output[] = '<div class="ui grid equal width compact">';
				$output[] = '<div class="row">';
				$used = [];
				for($i = 0; $i < (int)$unit['columns']; $i++){
					$output[] = '<div class="column">';
					foreach($subfields as $k => $field){
						if(!in_array($k, $used) AND (($k % (int)$unit['columns']) == $i)){
							$output[] = $field;
							$used[] = $k;
						}
					}
					$output[] = '</div>';
				}
				$output[] = '</div>';
				$output[] = '</div>';
				$subfields = [implode('', $output)];
			}
		}

		$_map = [
			'label' => ['children' => ['tooltip']],
			'container' => ['active' => true, 'children' => array_merge(['label'], $subfields, ['help'])],
		];

		return $this->setup($unit, $_map);
	}
	
	function setAttrs($unit, &$node){
		if(!empty($unit['attrs'])){
			foreach($unit['attrs'] as $k => $attr){
				if(isset($attr['name'])){
					$attr['name'] = $this->viewer->Parser->parse($attr['name']);
				}

				if(!empty($attr['name'])){
					if(empty($attr['override']) AND !empty($node['attrs'][$attr['name']])){
						if(!empty($node['attrs'][$attr['name']])){
							if(is_string($node['attrs'][$attr['name']])){
								$node['attrs'][$attr['name']] .= ' '.$this->viewer->Parser->parse($attr['value']);
							}else if(is_array($node['attrs'][$attr['name']])){
								$node['attrs'][$attr['name']]['attr'.$k] = $this->viewer->Parser->parse($attr['value']);
							}
						}
					}else{
						$node['attrs'][$attr['name']] = $this->viewer->Parser->parse($attr['value']);
					}
				}
			}
		}
	}
	
}