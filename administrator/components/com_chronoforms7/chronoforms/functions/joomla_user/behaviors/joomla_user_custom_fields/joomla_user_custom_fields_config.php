<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(true OR $this->data('act') == 'refresh_element'){
		$unit['custom_fields'] = $unit['custom_fields'] ?? [];
		$Table = new \G3\L\Model(['name' => 'CustomField', 'table' => '#__fields']);
		$fields = $Table->where('context', 'com_users.user')->where('state', 1)->select('all');
		
		foreach($fields as $field){
			if(!isset($unit['custom_fields'][$field['CustomField']['id']])){
				$unit['custom_fields'][$field['CustomField']['id']] = [
					'id' => $field['CustomField']['id'],
					'title' => $field['CustomField']['title'],
				];
			}
		}
		
		$this->data['Connection'][$utype][$n]['custom_fields'] = $unit['custom_fields'];
	}
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['custom_fields'],
		'items' => $unit['custom_fields'] ?? [],
		// 'btns' => ['custom_fields' => ['main' => ['text' => rl3('Add Field'), 'color' => 'blue']]],
		'headers' => [
			'custom_fields' => [
				['width' => 'one wide', 'label' => rl3('ID')],
				['width' => 'six wide', 'label' => rl3('Title')],
				['width' => 'nine wide', 'label' => rl3('Value')],
				// ['width' => 'two wide', 'label' => ''],
			],
		],
		'inputs' => [
			'custom_fields' => [
				'main' => [
					'r1' => [
						[
							'width' => 'one wide',
							'params' => [
								'placeholder' => rl3('ID'), 
								'readonly' => 'readonly',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][custom_fields][#custom_fields#][id]']
							],
						],
						[
							'width' => 'six wide',
							'params' => [
								'placeholder' => rl3('Title'), 
								'readonly' => 'readonly',
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][custom_fields][#custom_fields#][title]']
							],
						],
						[
							'width' => 'nine wide',
							'type' => 'select',
							'options' => ['' => ''],
							'params' => [
								// 'placeholder' => rl3('Value'), 
								'class' => 'ui fluid dropdown search',
								'data-list' => '.inputsList',
								'data-types' => '["field_text", "field_select", "field_radios", "field_checkboxes"]',
								'data-allowadditions' => "1",
								'data-clearable' => "1",
								'origin' => ['name' => 'Connection['.$utype.']['.$n.'][custom_fields][#custom_fields#][value]']
							],
						],
						// [
						// 	'width' => 'two wide', 
						// 	'type' => 'btns',
						// 	'btns' => [
						// 		'add' => [],
						// 		'delete' => [],
						// 		// 'sort' => [],
						// 	]
						// ],
					],
				],
			],
		]
	]);
?>

<?php //$this->view($this->get('cf.paths.shared').'refresh_button.php', ['label' => rl3('Load custom fields'), 'color' => 'black']); ?>