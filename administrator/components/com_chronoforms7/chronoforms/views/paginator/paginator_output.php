<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$content = '';

	if(!empty($view['data_source']) AND !empty($this->Paginator)){ //check $this->Paginator for admin preview
		$read_data = $this->controller->FData->cdata('functions.'.$view['data_source']);
		$model = $read_data['models']['data']['vname'];

		$view['items'] = $view['items'] ?? [];

		if(in_array('navigation', $view['items'])){
			$content .= $this->Paginator->navigation($model);
		}

		if(in_array('limiter', $view['items'])){
			$content .= $this->Paginator->limiter($model);
		}

		if(in_array('limiter', $view['items'])){
			$content .= $this->Paginator->info($model);
		}
	}

	$_map = [
		'main' => ['tag' => 'div', 'content' => $content, 'attrs' => ['class' => ['ui container fluid']]],
	];

	echo $this->Field->build($view, $_map);