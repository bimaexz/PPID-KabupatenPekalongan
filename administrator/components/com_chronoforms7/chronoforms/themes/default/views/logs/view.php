<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$this->view('views.admin.page_menu', [
		'title' => rl3('Logs manager'),
		'class' => 'quti bg-cfpcolor',
		'btns' => [
			[
				'color' => 'inverted active',
				'href' => r3('index.php?ext=chronoforms&cont=logs&form_id='.$record['Datalog']['form_id']),
				'hint' => rl3('Close'),
				'icon' => 'times',
				'title' => rl3('Close Record'),
			],
		]
	]);
?>
<div class="ui bottom attached segment">
<table class="ui basic selectable table">
	<tbody>
		<tr>
			<td class="five wide blue"><strong><?php el3('ID'); ?></strong></td>
			<td><?php echo $record['Datalog']['aid']; ?></td>
		</tr>
		<tr>
			<td class="five wide blue"><strong><?php el3('Unique ID'); ?></strong></td>
			<td><?php echo $record['Datalog']['uid']; ?></td>
		</tr>
		<tr>
			<td class="five wide blue"><strong><?php el3('Created Date'); ?></strong></td>
			<td><?php echo $record['Datalog']['created']; ?></td>
		</tr>
		<tr>
			<td class="five wide blue"><strong><?php el3('Modified Date'); ?></strong></td>
			<td><?php echo $record['Datalog']['modified'] ?? ''; ?></td>
		</tr>
		<tr>
			<td class="five wide blue"><strong><?php el3('IP Address'); ?></strong></td>
			<td><?php echo $record['Datalog']['ipaddress']; ?></td>
		</tr>
		<tr>
			<td class="five wide blue"><strong><?php el3('User'); ?></strong></td>
			<td><?php echo $record['Datalog']['user_id']; ?></td>
		</tr>
		<?php foreach($record['Datalog']['data'] as $key => $value): ?>
			<?php
				if(!isset($connection['Connection']['views'][$key])){
					continue;
				}
				$unit = $connection['Connection']['views'][$key];
				$label = !empty($unit['nodes']['label']['content']) ? $unit['nodes']['label']['content'] : $unit['wtitle'];
				$fname = $unit['nodes']['main']['attrs']['name'];

				if(strpos($fname, '.#') !== false){
					if(!empty($record['Datalog']['data']['__loops'])){
						foreach($record['Datalog']['data']['__loops'] as $loopuid => $mloop){
							$model = $this->Parser->getModel($connection['Connection']['views'][$loopuid], $connection['Connection']['functions']);

							if(strpos($fname, '#'.$model.'.') !== false){
								foreach($mloop as $mk => $mv){
									echo '<tr>';
									echo '<td class="six wide warning"><strong>'.str_replace('#'.$model, $mk, $label).'</strong></td>';
									echo '<td class="ten wide green">'.$this->Parser->displayValue($unit, $value[$mk]).'</td>';
									echo '</tr>';
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
							echo '<tr>';
							echo '<td class="six wide warning"><strong>'.str_replace($indexes, $sk, $label).'</strong></td>';
							
							echo '<td class="ten wide green">'.$this->Parser->displayValue($unit, $svalue).'</td>';
							echo '</tr>';
						}
					}
				}else{
					echo '<tr>';
					echo '<td class="six wide warning"><strong>'.$label.'</strong></td>';
					echo '<td class="ten wide green">'.$this->Parser->displayValue($unit, $value).'</td>';
					echo '</tr>';
				}
			?>
		<?php endforeach; ?>
	</tbody>
</table>
</div>