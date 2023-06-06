<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	// $views = [];
	// foreach($this->data('Connection.views', []) as $vk => $view){
	// 	$views[$vk] = $vk;
	// }

	$options_settings =  [
		'empty' => json_encode(['hide' => ['.fevent_value', '.r2_values']]),
		'!empty' => json_encode(['hide' => ['.fevent_value', '.r2_values']]),
		'change' => json_encode(['hide' => ['.fevent_value', '.r2_values']]),
		'input' => json_encode(['hide' => ['.fevent_value', '.r2_values']]),
		'==' => json_encode(['hide' => ['.fevent_value'], 'show' => ['.fevent_value_single', '.r2_values']]),
		'!=' => json_encode(['hide' => ['.fevent_value'], 'show' => ['.fevent_value_single', '.r2_values']]),
		'regex' => json_encode(['hide' => ['.fevent_value'], 'show' => ['.fevent_value_single', '.r2_values']]),
		'>' => json_encode(['hide' => ['.fevent_value'], 'show' => ['.fevent_value_single', '.r2_values']]),
		'>=' => json_encode(['hide' => ['.fevent_value'], 'show' => ['.fevent_value_single', '.r2_values']]),
		'<' => json_encode(['hide' => ['.fevent_value'], 'show' => ['.fevent_value_single', '.r2_values']]),
		'<=' => json_encode(['hide' => ['.fevent_value'], 'show' => ['.fevent_value_single', '.r2_values']]),
		'in' => json_encode(['hide' => ['.fevent_value'], 'show' => ['.fevent_value_multi', '.r2_values']]),
		'!in' => json_encode(['hide' => ['.fevent_value'], 'show' => ['.fevent_value_multi', '.r2_values']]),
		'click' => json_encode(['hide' => ['.fevent_value', '.r2_values']]),
		'ready' => json_encode(['hide' => ['.fevent_value', '.r2_values']]),
		'reload' => json_encode(['hide' => ['.fevent_value', '.r2_values']]),
		'ajax_success' => json_encode(['hide' => ['.fevent_value', '.r2_values']]),
		'triggers' => json_encode(['hide' => ['.fevent_value'], 'show' => ['.fevent_value_single', '.r2_values']]),
	];

	$options_attrs =  [
		'empty' => [
			'data-vtypes' => json_encode([
				'field_text',
				'field_textarea',
				'field_password',
				'field_select',
				'field_calendar',
				'field_file',
				'wfield_signature',
				'wfield_rating',
				'field_radios',
				'field_checkboxes',
				'field_checkbox',
			])
		],
		'!empty' => [
			'data-vtypes' => json_encode([
				'field_text',
				'field_textarea',
				'field_password',
				'field_select',
				'field_calendar',
				'field_file',
				'wfield_signature',
				'wfield_rating',
				'field_radios',
				'field_checkboxes',
				'field_checkbox',
			])
		],
		'change' => [
			'data-vtypes' => json_encode([
				'field_text',
				'field_textarea',
				'field_password',
				'field_select',
				'field_calendar',
				'field_file',
				'wfield_signature',
				'wfield_rating',
				'field_radios',
				'field_checkboxes',
				'field_checkbox',
			])
		],
		'input' => [
			'data-vtypes' => json_encode([
				'field_text',
				'field_textarea',
				'field_password',
				'field_select',
				'field_calendar',
				'field_file',
				'wfield_signature',
				'wfield_rating',
				'field_radios',
				'field_checkboxes',
				'field_checkbox',
			])
		],
		'==' => [
			'data-vtypes' => json_encode([
				'field_text',
				'field_textarea',
				'field_password',
				'field_select',
				'field_calendar',
				'wfield_rating',
				'field_radios',
				'field_checkboxes',
			])
		],
		'!=' => [
			'data-vtypes' => json_encode([
				'field_text',
				'field_textarea',
				'field_password',
				'field_select',
				'field_calendar',
				'wfield_rating',
				'field_radios',
				'field_checkboxes',
			])
		],
		'regex' => [
			'data-vtypes' => json_encode([
				'field_text',
				'field_textarea',
				'field_password',
				'field_select',
				'field_calendar',
				'field_file',
			])
		],
		'>' => [
			'data-vtypes' => json_encode([
				'field_text',
				'field_select',
				'wfield_rating',
				'field_radios',
			])
		],
		'>=' => [
			'data-vtypes' => json_encode([
				'field_text',
				'field_select',
				'wfield_rating',
				'field_radios',
			])
		],
		'<' => [
			'data-vtypes' => json_encode([
				'field_text',
				'field_select',
				'wfield_rating',
				'field_radios',
			])
		],
		'<=' => [
			'data-vtypes' => json_encode([
				'field_text',
				'field_select',
				'wfield_rating',
				'field_radios',
			])
		],
		'in' => [
			'data-vtypes' => json_encode([
				'field_text',
				'field_password',
				'field_select',
				'field_calendar',
				'wfield_rating',
				'field_radios',
				'field_checkboxes',
			])
		],
		'!in' => [
			'data-vtypes' => json_encode([
				'field_text',
				'field_password',
				'field_select',
				'field_calendar',
				'wfield_rating',
				'field_radios',
				'field_checkboxes',
			])
		],
		'click' => [
			'data-vtypes' => json_encode([
				'field_button',
				'text_node',
			])
		],
		'reload' => [
			'data-vtypes' => json_encode(true)
		],
		'ajax_success' => [
			'data-vtypes' => json_encode(true)
		],
		'triggers' => [
			'data-vtypes' => json_encode(true)
		],
		'ready' => [
			'data-vtypes' => json_encode(true)
		],
	];
?>
<?php $this->view($this->get('cf.paths.shared').'clonable'.DS.'clonable.php', [
		'groups' => ['rules'],
		'items' => !empty($item['rules']) ? $item['rules'] : null,
		// 'btns' => ['vevents' => ['main' => ['text' => rl3('Add New Event')]]],
		'visible' => ['rules' => 1],
		'parents' => !empty($parents) ? $parents : [],
		'inputs' => [
			'rules' => [
				'main' => [
					'r1' => [
						[
							'width' => 'one wide ui button compact basic center black aligned', 
							'type' => 'string',
							'string' => rl3('IF'),
						],
						[
							'width' => 'nine wide', 
							'type' => 'select',
							'options' =>  [$n => $n],
							'params' => [
								'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][rules][#rules#][source]'],
								'data-list' => '.inputsList,.actionsList,.areasList',
								'data-cfwizardjob' => 'view-event-source',
								'data-clearable' => '1',
								'data-keepnonexistent' => '1',
								'placeholder' => rl3('Select condition input'),
							],
						],
						[
							// 'width' => 'four wide feact feact_field_text feact_field_password feact_field_hidden', 
							'width' => 'four wide feact',
							'type' => 'select',
							'options' =>  [
								'empty' => rl3('is Empty'),
								'!empty' => rl3('is Not Empty'),
								'change' => rl3('Changes'),
								'input' => rl3('Input'),
								'==' => rl3('Equals'),
								'!=' => rl3('Not Equals'),
								'>' => rl3('Greater Than'),
								'>=' => rl3('Greater or Equal'),
								'<' => rl3('Less Than'),
								'<=' => rl3('Less or Equal'),
								'regex' => rl3('Matches Regex'),
								'in' => rl3('IN'),
								'!in' => rl3('NOT IN'),
								'click' => rl3('Clicked'),
								'ready' => rl3('Ready'),
								'triggers' => rl3('Triggers'),
								'reload' => rl3('ReLoaded'),
								'ajax_success' => rl3('Completes AJAX'),
							],
							'options_settings' =>  $options_settings,
							'options_attrs' => $options_attrs,
							'params' => [
								'data-cfwizardjob' => 'content-switcher',
								'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][rules][#rules#][action]']
							],
						],
						// [
						// 	'width' => 'four wide feact feact_field_select feact_field_checkboxes feact_field_radios', 
						// 	'type' => 'select',
						// 	'options' =>  [
						// 		'empty' => rl3('is Empty'),
						// 		'!empty' => rl3('is Not Empty'),
						// 		'changes' => rl3('Changes'),
						// 		'==' => rl3('on Selecting'),
						// 		'!=' => rl3('on UnSelecting'),
						// 		'regex' => rl3('Matches Regex'),
						// 		'in' => rl3('IN'),
						// 		'!in' => rl3('NOT IN'),
						// 		'triggers' => rl3('Triggers'),
						// 	],
						// 	'options_settings' =>  $options_settings,
						// 	'params' => [
						// 		'data-cfwizardjob' => 'content-switcher',
						// 		'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][rules][#rules#][action]']
						// 	],
						// ],
						// [
						// 	'width' => 'four wide feact feact_field_checkbox', 
						// 	'type' => 'select',
						// 	'options' =>  [
						// 		'!empty' => rl3('is Checked'),
						// 		'empty' => rl3('is Not Checked'),
						// 		'changes' => rl3('Changes'),
						// 		'triggers' => rl3('Triggers'),
						// 	],
						// 	'options_settings' =>  $options_settings,
						// 	'params' => [
						// 		'data-cfwizardjob' => 'content-switcher',
						// 		'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][rules][#rules#][action]']
						// 	],
						// ],
						// [
						// 	'width' => 'four wide feact feact_field_button', 
						// 	'type' => 'select',
						// 	'options' =>  [
						// 		'clicked' => rl3('Clicked'),
						// 		'triggers' => rl3('Triggers'),
						// 	],
						// 	'options_settings' =>  $options_settings,
						// 	'params' => [
						// 		'data-cfwizardjob' => 'content-switcher',
						// 		'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][rules][#rules#][action]']
						// 	],
						// ],
						// [
						// 	'width' => 'four wide feact feact_wfield_signature', 
						// 	'type' => 'select',
						// 	'options' =>  [
						// 		'empty' => rl3('is Empty'),
						// 		'!empty' => rl3('is Not Empty'),
						// 		'changes' => rl3('Changes'),
						// 		'triggers' => rl3('Triggers'),
						// 	],
						// 	'options_settings' =>  $options_settings,
						// 	'params' => [
						// 		'data-cfwizardjob' => 'content-switcher',
						// 		'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][rules][#rules#][action]']
						// 	],
						// ],
						// [
						// 	'width' => 'four wide feact feact_wfield_rating', 
						// 	'type' => 'select',
						// 	'options' =>  [
						// 		'empty' => rl3('is Empty'),
						// 		'!empty' => rl3('is Not Empty'),
						// 		'changes' => rl3('Changes'),
						// 		'==' => rl3('Equals'),
						// 		'!=' => rl3('Not Equals'),
						// 		'>' => rl3('Greater Than'),
						// 		'>=' => rl3('Greater or Equal'),
						// 		'<' => rl3('Less Than'),
						// 		'<=' => rl3('Less or Equal'),
						// 		'in' => rl3('IN'),
						// 		'!in' => rl3('NOT IN'),
						// 	],
						// 	'options_settings' =>  $options_settings,
						// 	'params' => [
						// 		'data-cfwizardjob' => 'content-switcher',
						// 		'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][rules][#rules#][action]']
						// 	],
						// ],
						// [
						// 	'width' => 'four wide feact feact_field_textarea feact_field_calendar feact_field_file', 
						// 	'type' => 'select',
						// 	'options' =>  [
						// 		'empty' => rl3('is Empty'),
						// 		'!empty' => rl3('is Not Empty'),
						// 		'changes' => rl3('Changes'),
						// 		'regex' => rl3('Matches Regex'),
						// 	],
						// 	'options_settings' =>  $options_settings,
						// 	'params' => [
						// 		'data-cfwizardjob' => 'content-switcher',
						// 		'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][rules][#rules#][action]']
						// 	],
						// ],
						[
							'width' => 'two wide', 
							'type' => 'btns',
							'btns' => [
								'add' => ['icon' => 'copy', 'color' => 'green'],
								'delete' => ['hidden' => 1],
								'sort' => ['color' => 'orange'],
							]
						],
					],
					'r2_values' => [
						[
							'width' => 'one wide', 
							'type' => 'empty',
						],
						/*[
							'width' => 'thirteen wide fevent_value fevent_value_single hidden', 
							'params' => [
								'placeholder' => rl3('Value'), 
								'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][rules][#rules#][value][]']
							],
						],*/
						[
							'width' => 'thirteen wide fevent_value fevent_value_single hidden', 
							'type' => 'select',
							'options' =>  [
								
							],
							'params' => [
							'multiple' => 'multiple',
								'placeholder' => rl3('Value'), 
								'data-allowadditions' => '1',
								'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][rules][#rules#][value][]']
							],
						],
						[
							'width' => 'thirteen wide fevent_value fevent_value_multi hidden', 
							'type' => 'select',
							'options' =>  [
								
							],
							'params' => [
								'multiple' => 'multiple',
								'placeholder' => rl3('Enter one or more comma separated values'),
								'data-allowadditions' => '1',
								'origin' => ['name' => 'Connection[views]['.$n.'][vevents][#vevents#][rules][#rules#][mvalue][]']
							],
						],
						[
							'width' => 'two wide', 
							'type' => 'empty',
						],
					],
				],
			],
		]
	]);
?>