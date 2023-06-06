<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$view['nodes']['main']['attrs']['id'] = $view['name'];

	$model = $view['name'];
	
	$results = [];
	if(!empty($view['data_source'])){
		$results = $this->controller->FData->dsources($view['data_source']);
	}

	if(!empty($this->data('__loops.'.$view['uid']))){
		$results = [];
		foreach($this->data('__loops.'.$view['uid'], []) as $key => $value){
			$results[$key] = $this->data($model.'.'.$key);
		}
	}

	$children = [];//['top' => $this->Parser->section($view['uid'].'/top')];
	
	if(!empty($view['cloner'])){
		$this->set('__loops.'.$model, '#'.$model);

		if(!empty($view['clonable'])){
			$this->controller->FData->cdata('views.'.$view['clonable'].'.nodes.main.attrs.class.clonable', 'clonable hidden', true);
			$this->controller->FData->cdata('views.'.$view['clonable'].'.nodes.main.attrs.data-group', $view['name'], true);
			$this->controller->FData->cdata('views.'.$view['clonable'].'.nodes.main.attrs.data-cloneindex', -1, true);
			$this->controller->FData->cdata('views.'.$view['clonable'].'.nodes.main.attrs.data-countindex', 0, true);
			$this->controller->FData->cdata('views.'.$view['clonable'].'.nodes.main.attrs.data-loopid', 1, true);
			$this->controller->FData->cdata('views.'.$view['clonable'].'.nodes.main.attrs.data-source', 1, true);
		}

		$content = $this->Parser->section($view['uid'].'/loop');
		$loop_input = '<input type="hidden" name="__loops['.$view['uid'].']['.$this->get('__loops.'.$model, '').']" value="1" disabled="disabled" />';

		$last_tag_pos = strrpos($content, '</');
		if($last_tag_pos !== false){
			$content = substr_replace($content, $loop_input.'</', $last_tag_pos, strlen('</'));
		}
		// $content .= '<input type="hidden" name="__loops['.$view['uid'].']['.$this->get('__loops.'.$model, '').']" value="1" disabled="disabled" />';

		if(empty($view['clonable'])){
			$children['source'] = [
				'tag' => 'div', 
				'active' => true,
				'content' => $content, 
				'attrs' => [
					'class' => ['field clonable hidden'],
					'data-group' => $view['name'],
					// 'data-grouptype' => 'main',
					'data-cloneindex' => -1,//0,
					'data-source' => 1,
				]
			];
		}else{
			$children['source'] = $content;
		}

		$this->set('__loops.'.$model, null);

		if(!empty($view['clonable'])){
			$this->controller->FData->cdata('views.'.$view['clonable'].'.nodes.main.attrs.data-source', null, true);
		}
	}

	$count = 1;
	foreach($results as $ik => $result){
		$k = $ik;// + 1;
		// $this->set($model.'.index', $k);
		// $this->set($model.'.count', $count);
		// $this->set('__loops.'.$view['model'], $k);

		$this->set($view['name'].'.key', $k);

		$this->set('__loops.'.$model, $k);
		$this->set('__loops_counts.'.$model, $count);

		$row_data = [];
		if(is_array($result)){
			foreach($result as $mkey => $mdata){
				$this->set($mkey, $result[$mkey]);
				$row_data[$mkey][$k] = $result[$mkey];
			}
		}
		// else{
		// 	$this->set('__loops.'.$model, $k);
		// }
		
		// $child_clonable = false;
		// if(!empty($view['_dchildren']) AND count($view['_dchildren']) == 1){
		// 	$cuid = array_values($view['_dchildren'])[0];
		// 	$child = $this->controller->FData->cdata('views.'.$cuid);
		// 	if(strpos($child['type'], 'area_') === 0){
		// 		$child_clonable = true;
		// 	}
		// }

		if(!empty($view['clonable'])){
			$this->controller->FData->cdata('views.'.$view['clonable'].'.nodes.main.attrs.class.clonable', 'clonable', true);
			$this->controller->FData->cdata('views.'.$view['clonable'].'.nodes.main.attrs.data-group', $view['name'], true);
			$this->controller->FData->cdata('views.'.$view['clonable'].'.nodes.main.attrs.data-cloneindex', $k, true);
			$this->controller->FData->cdata('views.'.$view['clonable'].'.nodes.main.attrs.data-countindex', $count, true);
			$this->controller->FData->cdata('views.'.$view['clonable'].'.nodes.main.attrs.data-loopid', 1, true);
		}

		$content = $this->Parser->section($view['uid'].'/loop');
		$loop_input = '<input type="hidden" name="__loops['.$view['uid'].']['.$this->get('__loops.'.$model, '').']" value="1" />';

		$last_tag_pos = strrpos($content, '</');
		if($last_tag_pos !== false){
			$content = substr_replace($content, $loop_input.'</', $last_tag_pos, strlen('</'));
		}

		// $content .= '<input type="hidden" name="__loops['.$view['uid'].']['.$this->get('__loops.'.$model, '').']" value="1" />';
		
		$content = $this->controller->Parser->dataLoad($content, $row_data);

		if(!empty($view['cloner']) AND empty($view['clonable'])){
			$children['clone'.($k)] = [
				'tag' => 'div', 
				'active' => true,
				'content' => $content, 
				'attrs' => [
					'class' => ['field clonable'],
					'data-group' => $view['name'],
					// 'data-grouptype' => 'main',
					'data-cloneindex' => $k,
					'data-countindex' => $count,
					'data-loopid' => 1,
				]
			];
		}else{
			$children['clone'.($k)] = $content;
		}
		$count++;

		if(is_array($result)){
			foreach($result as $mkey => $mdata){
				$this->set($mkey, null);
			}
		}

		$this->set('__loops.'.$model, null);
		$this->set('__loops_counts.'.$model, null);
		$this->set($view['name'].'.key', null);
	}

	$_map = [
		'main' => [
			'tag' => 'div', 
			'children' => array_keys($children), 
			'attrs' => [
				'class' => ['ui fluid container clonable_container'],
				'data-group' => $view['name'],
				'data-match' => $model,
				'data-lastindex' => !empty($results) ? max(array_keys($results)) : 0,
			]
		],
	];

	$_map = array_merge($children, $_map);

	echo $this->Field->build($view, $_map);

	return;
	// $items = $this->Parser->parse($view['data_provider']);
	// $keys = $this->Parser->parse($view['keys_provider']);
	
	// if(is_numeric($items)){
	// 	$items = range(0, (int)$items);
	// }
	
	// if(empty($items)){
	// 	$items = [];
	// }
	
	// if(is_numeric($keys)){
	// 	$keys = range((int)$keys, max(array_keys($items)));
	// }
	
	// if(!is_array($items)){
	// 	$items = [];
	// }
	
	// if($this->get('_preview') AND empty($items)){
	// 	$items = [0];
	// }
	
	// if(is_array($items)){
	// 	$this->set('__multiplier_model', (!empty($view['model']) ? $view['model'] : false));
	// 	$this->set('__multiplier_name', $view['name']);
		
	// 	echo '<div class="'.$view['class'].' repeater" data-count="'.count($items).'" data-limit="'.(!empty($view['max_clones']) ? $view['max_clones'] : '').'">';
			
	// 		//if(!empty($view['multiplier'])){
	// 			$this->set('__multiplier_source', '#'.$view['name'].'.count');
	// 			echo '<div class="ui container fluid source-item" data-name="'.$view['name'].'">';
	// 				$this->set($view['name'].'.key', '-N-');
	// 				$this->set($view['name'].'.key', '#'.$view['name'].'.count');
	// 				echo $this->Parser->section($view['uid'].'/body');
	// 				echo '<div class="ui divider"></div>';
	// 			echo '</div>';
	// 			$this->set('__multiplier_source', null);
	// 		//}
			
	// 		$this->set('__multiplier_clone', true);
	// 		foreach($items as $key => $item){
	// 			if(is_array($keys) AND !in_array($key, $keys)){
	// 				continue;
	// 			}
	// 			$this->set($view['name'].'.row', $item);
	// 			$this->set($view['name'].'.key', $key);
	// 			echo '<div class="ui container fluid clone-item">';
	// 				echo $this->Parser->section($view['uid'].'/body');
	// 				echo '<div class="ui divider"></div>';
	// 			echo '</div>';
	// 		}
	// 		$this->set('__multiplier_clone', null);
	// 		$this->set('__multiplier_model', null);
			
	// 		echo $this->Parser->section($view['uid'].'/footer');
	
	// 	echo '</div>';
	// }