<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$results = [];
	if(!empty($view['data_source'])){
		$results = $this->controller->FData->dsources($view['data_source']);
	}
	
	// if(!empty($view['single_record'])){
	// 	$result = $results;
	// 	foreach($result as $mkey => $mdata){
	// 		$this->set($mkey, $result[$mkey]);
	// 	}
	// 	$results = [];
	// }

	// if(!empty($view['static_source']['uid'])){
	// 	foreach($view['static_source']['uid'] as $static_uid){
	// 		if(is_numeric($static_uid)){
	// 			$static_data = $this->controller->FData->cdata('functions.'.$static_uid);
	// 			$static_items = $this->get($static_data['name'], []);

	// 			foreach($static_items as $sk => $sdata){
	// 				$nresult = [];
	// 				if(!empty($sdata['pairs'])){
	// 					foreach($sdata['pairs'] as $pk => $pair){
	// 						$nresult = \G3\L\Arr::setVal($nresult, $pair['key'], $pair[$pair['type']]);
	// 					}
	// 				}
	// 				if($view['static_source']['pos'] == 'append'){
	// 					array_push($results, $nresult);
	// 				}else{
	// 					array_unshift($results, $nresult);
	// 				}
	// 			}
	// 		}
	// 	}
	// }

	// if(!empty($view['empty_range'])){
	// 	foreach(range(1, (int)$view['empty_range']['max']) as $nresult){
	// 		$nresult = [];
	// 		if($view['empty_range']['pos'] == 'append'){
	// 			array_push($results, $nresult);
	// 		}else{
	// 			array_unshift($results, $nresult);
	// 		}
	// 	}
	// }

	$column_class = function($area, $column, $header = []){
		$classes = [];
		$classes[] = \G3\L\Str::slug($area['name'], '-');
		$classes[] = $column['width'].' '.($header['width'] ?? '');
		$classes[] = $column['class'].' '.($header['class'] ?? '');
		return implode(' ', array_filter($classes));
	};

	$column_content = function($area, $result, $row_data) use($view) {
		$content_found = $this->Parser->section($view['uid'].'/'.$area['name']);

		if(!empty($content_found)){
			return $this->controller->Parser->dataLoad($content_found, $row_data);
		}else{
			return \G3\L\Arr::getVal($result, $area['name'], '');
		}
	};

	// $top_section = $this->Parser->section($view['uid'].'/Top');
	// echo $top_section;
	// unset($view['areas']['Top']);

	$contents = [];
	if(!empty($view['areas'])){
		if(empty($view['table_headers_disabled'])){
			$contents[] = '<thead><tr>';
			foreach($view['areas'] as $sk => $column){
				if(!isset($view['columns'][$sk])){
					continue;
				}
				
				$contents[] = '<th class="'.$column_class($view['areas'][$sk], $view['columns'][$sk]).'">';

				if(!empty($view['areas'][$sk]['before']['header'])){
					$contents[] = $this->Parser->section($view['uid'].'/'. str_replace('{name}', $view['areas'][$sk]['name'], $view['areas'][$sk]['before']['header']));
				}else{
					if(!empty($view['sortables']) AND in_array($view['areas'][$sk]['name'], $view['sortables'])){
						$contents[] = $this->Sorter->link($view['columns'][$sk]['title'], \G3\L\Str::slug($view['areas'][$sk]['name'], '-'));
					}else{
						$contents[] = $view['columns'][$sk]['title'];
					}
				}
				$contents[] = '</th>';
			}
			$contents[] = '</tr></thead>';
		}

		if(!empty($results)){
			$contents[] = '<tbody>';
			foreach($results as $rkey => $result){
				$this->set($view['name'].'.key', $rkey);

				$contents[] = '<tr data-loopid="1">';
				foreach($view['areas'] as $sk => $column){
					if(!isset($view['columns'][$sk])){
						continue;
					}
					
					$contents[] = '<td class="'.$column_class($view['areas'][$sk], $view['columns'][$sk]).'">';

					$row_data = [];
					if(is_array($result)){
						foreach($result as $mkey => $mdata){
							$this->set($mkey, $result[$mkey]);
							$this->set('__loops.'.$mkey, $rkey);
							$row_data[$mkey][$rkey] = $result[$mkey];
						}
					}

					$contents[] = $column_content($view['areas'][$sk], $result, $row_data);

					$contents[] = '</td>';
				}
				$contents[] = '</tr>';
			}
			$contents[] = '</tbody>';
		}
	}

	$table = implode('', $contents);

	$view['nodes']['main']['attrs']['id'] = $view['name'];

	// if(!empty($view['areas'])){
	// 	$count = [
	// 		2 => 'two column',
	// 		3 => 'three column',
	// 		4 => 'four column',
	// 		5 => 'five column',
	// 		6 => 'six column',
	// 		7 => 'seven column',
	// 		8 => 'eight column',
	// 		9 => 'nine column',
	// 		10 => 'ten column',
	// 	];

	// 	if(isset($count[count($view['areas'])])){
	// 		//$view['nodes']['main']['attrs']['class']['auto'] = $count[count($view['areas'])];
	// 	}
	// }

	$_map = [
		'main' => ['tag' => 'table', 'content' => $table, 'attrs' => ['class' => ['ui table']]],
	];

	echo $this->Field->build($view, $_map);