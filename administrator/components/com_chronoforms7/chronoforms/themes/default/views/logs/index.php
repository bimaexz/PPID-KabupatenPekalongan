<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$fields = [];
	foreach($records as $k => $record){
		$records[$k]['Datalog']['data'] = json_decode($record['Datalog']['data'], true);
		$fields = array_unique(array_merge($fields, array_keys($records[$k]['Datalog']['data'])));
	}
?>
<?php
	$this->view('views.admin.page_menu', [
		'title' => rl3('DataLog for %s', [$connection['Connection']['title']]),
		'class' => 'quti bg-cfpcolor',
		'search' => ['text' => rl3('Search records')],
		'paginator' => 'Datalog',
		'btns' => [
			[
				'color' => 'inverted active',
				'href' => r3('index.php?ext=chronoforms&cont=connections'),
				'hint' => rl3('Back to Forms Manager'),
				'icon' => 'arrow-left',
				'title' => rl3('Forms Manager'),
			],
			[
				'color' => 'inverted active',
				'href' => r3('index.php?ext=chronoforms&cont=logs&act=csv&form_id='.$connection['Connection']['id']),
				'hint' => rl3('If no records are selected then all will be exported'),
				'icon' => 'download',
				'title' => rl3('CSV Export'),
			],
			[
				'color' => 'inverted active',
				'url' => r3('index.php?ext=chronoforms&cont=logs&act=delete&form_id='.$connection['Connection']['id']),
				'hint' => rl3('Delete Selected Records'),
				'icon' => 'trash',
				'title' => rl3('Delete'),
				'selections' => '1',
				'message' => rl3('Please make a selection'),
			],
		]
	]);
?>
<div class="ui container fluid">
<?php
	$listing_fields = [
		[
			'name' => 'Datalog.view', 
			'title' => rl3('View'),
			'content' => function($row){
				return $this->Html->a(rl3('View'), r3('index.php?ext=chronoforms&cont=logs&act=view&aid='.$row['Datalog']['aid']));
			}
		],
		[
			'name' => 'Datalog.aid', 
			'title' => rl3('ID'),
			'content' => function($row){
				return $row['Datalog']['aid'];
			}
		],
		[
			'name' => 'Datalog.created', 
			'title' => rl3('Date'),
			'content' => function($row){
				return $row['Datalog']['created'].(!empty($row['Datalog']['created']) ? '<br><small>'.($row['Datalog']['modified'] ?? '').'</small>' : '');
			}
		],
		[
			'name' => 'Datalog.user_id', 
			'title' => rl3('User ID'),
			'content' => function($row){
				return $row['Datalog']['user_id'].'<br>'.'<small>'.($row['User']['username'] ?? '').'</small>';
			}
		],
		[
			'name' => 'Datalog.data', 
			'title' => rl3('Data'),
			'class' => 'ten wide',
			'content' => function($row) use($connection){
				$output = '<table class="ui table very compact very basic">';
				foreach($row['Datalog']['data'] as $key => $value){
					if(!isset($connection['Connection']['views'][$key])){
						continue;
					}
					$unit = $connection['Connection']['views'][$key];
					$label = !empty($unit['nodes']['label']['content']) ? $unit['nodes']['label']['content'] : $unit['wtitle'];
					$fname = $unit['nodes']['main']['attrs']['name'];

					if(strpos($fname, '.#') !== false){
						if(!empty($row['Datalog']['data']['__loops'])){
							foreach($row['Datalog']['data']['__loops'] as $loopuid => $mloop){
								$model = $this->Parser->getModel($connection['Connection']['views'][$loopuid], $connection['Connection']['functions']);
								if(strpos($fname, '#'.$model.'.') !== false){
									foreach($mloop as $mk => $mv){
										$output .= '<tr>';
										$output .= '<td class="six wide warning"><strong>'.str_replace('#'.$model, $mk, $label).'</strong></td>';
										
										$output .= '<td class="ten wide green">'.$this->Parser->displayValue($unit, $value[$mk]).'</td>';
										$output .= '</tr>';
									}
								}
							}
						}else{
							$pcs = explode('.', $fname);
							$indexes = [];
							foreach($pcs as $pc){
								if(strpos($pc, '#') === 0){
									$indexes[] = $pc;
								}
							}
							foreach((array)$value as $sk => $svalue){
								$output .= '<tr>';
								$output .= '<td class="six wide warning"><strong>'.str_replace($indexes, $sk, $label).'</strong></td>';
								
								$output .= '<td class="ten wide green">'.$this->Parser->displayValue($unit, $svalue).'</td>';
								$output .= '</tr>';
							}
						}
					}else{
						$output .= '<tr>';
						$output .= '<td class="six wide warning"><strong>'.$label.'</strong></td>';
						
						$output .= '<td class="ten wide green">'.$this->Parser->displayValue($unit, $value).'</td>';
						$output .= '</tr>';
					}
				}
				$output .= '</table>';

				return $output;
			}
		],
	];
	
	$this->view('views.admin.listing', [
		'id' => 'Datalog.aid',
		'paginator' => 'Datalog',
		'fields' => $listing_fields,
		'rows' => $records,
	]);
?>
</div>
<input type="hidden" name="form_id" />