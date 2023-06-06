<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(0){
		echo '<button class="g-recaptcha ui button blue" data-sitekey="'.$view['site_key'].'" data-callback="">Submit</button>';
	}else{
		$_map = [
			'container' => ['attrs' => ['id' => $view['name']]],
		];

		echo $this->Field->build($view, $_map);
	}

	$chart_data = [];
	if(!empty($view['data_source'])){
		$results = $this->controller->FData->dsources($view['data_source']);
		if(!empty($results) AND !empty($view['columns'])){
			$row = [];
			foreach($view['columns'] as $ck => $column){
				$row[] = $column['title'];
			}
			$chart_data[] = $row;

			foreach($results as $k => $result){
				$row = [];
				foreach($view['columns'] as $ck => $column){
					if($ck > 1){
						$row[] = (int)\G3\L\Arr::getVal($result, explode('.', $column['path']), null);
					}else{
						$row[] = \G3\L\Arr::getVal($result, explode('.', $column['path']), null);
					}
				}
				$chart_data[] = $row;
			}
		}
	}

	$options = [
		'title' => $view['chart']['options']['title'] ?? '', 
		'width' => $view['chart']['options']['width'] ?? '100%', 
		'height' => $view['chart']['options']['height'] ?? '400', 
	];

	if(!empty($view['chart_options'])){
		foreach($view['chart_options'] as $opt){
			$options[$opt['name']] = $opt['value'];
		}
	}

	$options = array_replace($options, $view['chart']['options'] ?? []);

	foreach($options as $k => $v){
		$options[$k] = $this->Parser->parse($v);
	}
	
	ob_start();
?>
	<script>
		// Load google charts
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);

		// Draw the chart and set the chart values
		function drawChart() {
			var data = google.visualization.arrayToDataTable(<?php echo json_encode($chart_data); ?>);

			var options = <?php echo json_encode($options); ?>;

			var chart = new google.visualization.<?php echo $view['chart']['type'] ?? 'PieChart'; ?>(document.getElementById('<?php echo $view['name']; ?>'));
			chart.draw(data, options);
		}
	</script>
<?php
	$jscode = ob_get_clean();
	
	$js_url = 'https://www.gstatic.com/charts/loader.js';

	if(empty(\GApp3::instance()->tvout)){
		\GApp3::document()->addJsFile($js_url);
		\GApp3::document()->addHeaderTag($jscode);
	}else{
		echo '<script src="'.$js_url.'"></script>';
		echo $jscode;
	}