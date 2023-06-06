<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if($this->data('act') == 'refresh_element' AND !empty($unit['models']['data']['name'])){
		$unit['models']['data']['sources'] = $unit['models']['data']['sources'] ?? [];
		$Table = new \G3\L\Model(['name' => 'Table', 'table' => $unit['models']['data']['name']]);
		//refresh the table fields
		$Table->tablefields(true);
		foreach($Table->tablefields as $tablefield){
			if(!isset($unit['models']['data']['sources'][$tablefield])){
				$unit['models']['data']['sources'][$tablefield] = [
					'field' => $tablefield,
					'fn' => '',
				];
			}
		}
		
		$this->data['Connection'][$utype][$n]['models']['data']['sources'] = $unit['models']['data']['sources'];
	}
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['sources'],
		'items' => $unit['models']['data']['sources'] ?? [],
		'btns' => ['sources' => ['main' => ['text' => rl3('Add Data Source'), 'color' => 'blue']]],
		'headers' => [
			'sources' => [
				['width' => 'four wide', 'label' => rl3('Table field name')],
				['width' => 'four wide', 'label' => rl3('Value')],
				['width' => 'three wide', 'label' => rl3('Value Type')],
				['width' => 'three wide', 'label' => rl3('Action')],
				['width' => 'two wide', 'label' => ''],
			],
		],
		'inputs' => [
			'sources' => [
				'main' => [
					'r1' => [
						[
							'width' => 'four wide',
							'params' => [
								'placeholder' => rl3('Table field name'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][sources][#sources#][field]']
							],
						],
						[
							'width' => 'four wide',
							'params' => [
								'placeholder' => rl3('Value'), 
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][sources][#sources#][value]']
							],
						],
						[
							'width' => 'three wide', 
							'type' => 'select',
							'options' =>  [
								'' => rl3('Use Value'),
								'datetime' => rl3('DateTime'),
								'user_id' => rl3('User ID'),
								'increment' => rl3('Increment'),
								'decrement' => rl3('Decrement'),
								'json' => rl3('JSON Encode'),
							],
							'params' => [
								'placeholder' => '',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][sources][#sources#][fn]']
							],
						],
						[
							'width' => 'three wide', 
							'type' => 'select',
							'options' =>  [
								'' => rl3('Insert & Update'),
								'insert' => rl3('Insert'),
								'update' => rl3('Update'),
							],
							'params' => [
								'placeholder' => '',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][models][data][sources][#sources#][op]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'btns',
							'btns' => [
								'add' => [],
								'delete' => [],
								'sort' => [],
							]
						],
					],
				],
			],
		]
	]);
?>

<?php $this->view($this->get('cf.paths.shared').'refresh_button.php', ['label' => rl3('Load table fields'), 'color' => 'black']); ?>