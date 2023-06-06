<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\A\E\Chronoforms\L;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Converter{
	// var $locales = [];

	// var $_models = ['\G3\A\E\Chronoforms\M\Locale'];

	public static function core($data = []){
		$form7 = [
			'title' => '',
			'alias' => '',
			'published' => 0,
			'apptype' => 'form',
			'settings' => [
				'form' => [
					'uid' => 'form',
					'type' => 'form',
					'utype' => 'settings',
					'behaviors' => [
						'data' => [
							'check_security_fields',
							'validate_fields',
							'upload_files',
						],
					],
				]
			],
			'pgroups' => [
				1 => [
					'type' => '',
					'site' => '',
					'name' => 'form',
				]
			],
			'pages' => [
				
			],

			'views' => [],
			'functions' => [],
		];

		return array_merge($form7, $data);
	}

	//missing the container options
	//missing fields validations custom functions
	//missing fields events
	//missing data read
	//missing payment actions
	//missing authenticator not working correct
	public static function cf5($form, $dupdate = []){

		$actions_map = [
			'thanks_message' => [
				'type' => 'message',
				'data' => [
					'message' => [
						'path' => 'content',
					],
				]
			],
			'debugger' => [
				'type' => '_settings',
				'data' => [
					'debug' => [
						'behaviors' => ['data' => ['debug']],
					],
				]
			],
			'custom_code' => [
				'type' => 'php',
				'data' => [
					'content' => [
						'path' => 'code',
						'behaviors' => ['php' => ['php_html_support']],
					],
				]
			],
			'event_switcher' => [
				'type' => 'php',
				'data' => [
					'content' => [
						'path' => 'code',
						'behaviors' => ['php' => ['php_html_support', 'php_events']],
					],
				]
			],
			'authenticator' => [
				'type' => 'group',
				'data' => [
					'access' => [
						'path' => 'rules.access',
						'behaviors' => ['data' => ['group_permissions']],
					],
				]
			],
			'file_download' => [
				'type' => 'download',
				'data' => [
					'path' => [
						'path' => 'path',
					],
				]
			],
			'redirect' => [
				'type' => 'redirect',
				'data' => [
					'url' => [
						'path' => 'pageurl',
					],
				]
			],
			'curl' => [
				'type' => 'curl',
				'data' => [
					'target_url' => [
						'path' => 'url',
					],
					'header_in_response' => [
						'path' => 'header',
					],
				]
			],
			'db_save' => [
				'type' => 'save_data',
				'data' => [
					'tablename' => [
						'path' => 'models.data.name',
					],
					'model_id' => [
						'path' => 'models.data.vname',
					],
				]
			],
			// 'show_stopper' => [
			// 	'type' => 'php',
			// ],
			'user_loggedin' => [
				'type' => 'group',
			],
			'email' => [
				'type' => 'email',
			],
			'file_upload' => [
				'type' => 'upload',
			],
		];

		$form7 = self::core([
			'id' => $form['Connection']['id'],
			'title' => $form['Connection']['title'],
			'alias' => $form['Connection']['title'],
			'published' => $form['Connection']['published']
		]);

		$form7 = array_replace($form7, $dupdate);

		$form = $form['Connection'];
		$units = is_array($form['extras']) ? $form['extras'] : unserialize(\base64_decode($form['extras']));

// pr($units);

		$fields7['files'] = [];

		if(!empty($form['params']['description'])){
			$form7['settings']['form']['behaviors']['admin'][] = 'form_description';
			$form7['description'] = $form['params']['description'];
		}

		if(!empty($units['DNA'])){
			$pages_ids = [];
			$pcount = 1;
			foreach(array_keys($units['DNA']) as $page){
				$form7['pages'][$pcount] = [
					'pgroup' => 1,
					'minimized' => '0',
					'name' => $page,
				];

				$pages_ids[$page] = $pcount;

				$pcount++;
			}

			foreach($units['DNA'] as $page => $actions){
				if(!empty($actions)){
					$actions = \G3\L\Arr::flatten($actions, 2);
					foreach($actions as $action => $events){
						if(strpos($action, '_') === false){
							continue;
						}
						$action = explode('_', $action);
						$action_id = array_pop($action);
						$action = implode('_', $action);

						if(!empty($events)){
							foreach($events as $event => $event_actions){
								if(!empty($event_actions)){
									if(in_array($action, [
										'check_captcha',
										'check_nocaptcha',
										'check_recaptcha',
										'check_security_question',
										'check_honeypot',
										'server_validation',
										'file_upload',
									]) AND ($event == 'success')){
										continue;
									}else{
										foreach(array_keys($event_actions) as $event_action){
											$event_action = explode('_', $event_action);
											$event_action_id = array_pop($event_action);
											$units['actions_config'][$event_action_id]['_parent'] = $action_id;
											$units['actions_config'][$event_action_id]['_area'] = $event;
										}
									}
								}
							}
						}

						$action7 = [
							'uid' => $action_id,
							'_parent' => $units['actions_config'][$action_id]['_parent'] ?? '',
							'_area' => $units['actions_config'][$action_id]['_area'] ?? $pages_ids[$page],
							'name' => $action.'_'.$action_id,
							'utype' => 'functions',
							'behaviors' => []
						];

						if(!empty($actions_map[$action])){
							if($actions_map[$action]['type'] == '_settings'){
								if(!empty($actions_map[$action]['data'])){
									foreach($actions_map[$action]['data'] as $pname => $pdata){
										if(!empty($pdata['path'])){
											$action7 = \G3\L\Arr::setVal($action7, $pdata['path'], \G3\L\Arr::getVal($units['actions_config'][$action_id], $pname, ''));
										}

										if(!empty($pdata['behaviors'])){
											$form7['settings']['form']['behaviors'] = array_merge_recursive($form7['settings']['form']['behaviors'], $pdata['behaviors']);
										}
									}
								}
							}else{
								$action7['type'] = $actions_map[$action]['type'];
								
								if(!empty($actions_map[$action]['data'])){
									foreach($actions_map[$action]['data'] as $pname => $pdata){
										if(!empty($pdata['path'])){
											$action7 = \G3\L\Arr::setVal($action7, $pdata['path'], \G3\L\Arr::getVal($units['actions_config'][$action_id], $pname, ''));
										}

										if(!empty($pdata['behaviors'])){
											$action7['behaviors'] = array_merge_recursive($action7['behaviors'], $pdata['behaviors']);
										}
									}
								}

								if($action == 'event_switcher'){
									$action_events = explode(',', $units['actions_config'][$action_id]['events']);
									foreach($action_events as $aek => $action_event){
										$action7['areas'][$aek + 1]['name'] = $action_event;
										$action7['areas'][$aek + 1]['value'] = $action_event;
									}
								}

								if($action == 'custom_code'){
									$action7['code'] = str_replace('$form', '$this', $action7['code']);
								}

								if($action == 'user_loggedin'){
									$action7['behaviors']['group'][] = 'group_events';

									$action7['areas'][1]['name'] = 'true';
									$action7['switch_events'][1]['rules'][1]['first'] = '{user:id}';
									$action7['switch_events'][1]['rules'][1]['sign'] = '!empty';

									$action7['areas'][2]['name'] = 'false';
									$action7['switch_events'][2]['rules'][1]['first'] = '{user:id}';
									$action7['switch_events'][2]['rules'][1]['sign'] = 'empty';
								}

								if($action == 'authenticator'){
									$action7['areas'][1]['name'] = 'success';

									$action7['areas'][2]['name'] = 'fail';
								}

								if($action == 'db_save'){
									$action7['models']['data']['action'] = 'insert:update';
									if(!empty($units['actions_config'][$action_id]['force_save'])){
										$action7['models']['data']['action'] = 'insert';
									}

									if(!empty($units['actions_config'][$action_id]['save_under_modelid'])){
										$action7['models']['data']['sets'] = ['{data:'.$units['actions_config'][$action_id]['model_id'].'}'];
									}else{
										$action7['models']['data']['sets'] = ['{data:}'];
									}
								}

								if($action == 'redirect'){
									if($units['actions_config'][$action_id]['extra_params']){
										$params = explode("\n", $units['actions_config'][$action_id]['extra_params']);
										foreach($params as $aek => $param){
											$action7['parameters'][$aek + 1]['name'] = explode('=', $param)[0];
											if(!empty(explode('=', $param)[1])){
												if(strpos(explode('=', $param)[1], '"') === 0){
													$action7['parameters'][$aek + 1]['value'] = str_replace('"', '', explode('=', $param)[1]);
												}else{
													$action7['parameters'][$aek + 1]['value'] = '{data:'.explode('=', $param)[1].'}';
												}
											}
										}
									}
								}

								if($action == 'curl'){
									if($units['actions_config'][$action_id]['content']){
										$params = explode("\n", $units['actions_config'][$action_id]['content']);
										foreach($params as $aek => $param){
											$action7['parameters'][$aek + 1]['name'] = explode('=', $param)[0];
											if(!empty(explode('=', $param)[1])){
												if(strpos(explode('=', $param)[1], '"') === 0){
													$action7['parameters'][$aek + 1]['value'] = str_replace('"', '', explode('=', $param)[1]);
												}else{
													$action7['parameters'][$aek + 1]['value'] = '{data:'.explode('=', $param)[1].'}';
												}
											}
										}
									}
								}

								// if($action == 'show_stopper'){
								// 	$action7['code'] = '$this->controller->Page->stopped = true;';
								// }

								if($action == 'email'){
									$action7['subject'] = !empty($units['actions_config'][$action_id]['dsubject']) ?  '{data:'.$units['actions_config'][$action_id]['dsubject'].'}' : $units['actions_config'][$action_id]['subject'];

									$action7['reply_name'] = !empty($units['actions_config'][$action_id]['reply_name']) ?  $units['actions_config'][$action_id]['reply_name'] : null;

									$action7['reply_email'] = !empty($units['actions_config'][$action_id]['reply_email']) ?  $units['actions_config'][$action_id]['reply_email'] : null;

									$action7['recipients'] = explode(',', $units['actions_config'][$action_id]['to']);
									if(!empty($units['actions_config'][$action_id]['dto'])){
										foreach(explode(',', $units['actions_config'][$action_id]['dto']) as $dto){
											$action7['recipients'][] = '{data:'.$dto.'}';
										}
									}

									$action7['body'] = !empty($units['actions_config'][$action_id]['template']) ?  str_replace('{', '{data:', $units['actions_config'][$action_id]['template']) : '{email_content}';

									if(!empty($units['actions_config'][$action_id]['cc']) OR !empty($units['actions_config'][$action_id]['dcc'])){
										if(!empty(trim($units['actions_config'][$action_id]['cc']))){
											foreach(explode(',', $units['actions_config'][$action_id]['cc']) as $cc){
												$action7['cc'][] = $cc;
											}
										}
										if(!empty(trim($units['actions_config'][$action_id]['dcc']))){
											foreach(explode(',', $units['actions_config'][$action_id]['dcc']) as $dcc){
												$action7['cc'][] = '{data:'.$dcc.'}';
											}
										}

										$action7['behaviors']['email'][] = 'email_cc_bcc';
									}
									if(!empty($units['actions_config'][$action_id]['bcc']) OR !empty($units['actions_config'][$action_id]['dbcc'])){
										if(!empty(trim($units['actions_config'][$action_id]['bcc']))){
											foreach(explode(',', $units['actions_config'][$action_id]['bcc']) as $bcc){
												$action7['bcc'][] = $bcc;
											}
										}
										if(!empty(trim($units['actions_config'][$action_id]['dbcc']))){
											foreach(explode(',', $units['actions_config'][$action_id]['dbcc']) as $dbcc){
												$action7['bcc'][] = '{data:'.$dbcc.'}';
											}
										}

										$action7['behaviors']['email'][] = 'email_cc_bcc';
									}
								}

								if($action == 'file_upload'){
									$action7['path'] = $units['actions_config'][$action_id]['upload_path'];
									$action7['size'] = $units['actions_config'][$action_id]['max_size'];
									$action7['errors'] = [
										'extensions' => $units['actions_config'][$action_id]['type_error'],
										'size' => $units['actions_config'][$action_id]['max_error'],
									];

									$files = explode("\n", $units['actions_config'][$action_id]['files']);
									foreach($files as $aek => $file){
										$action7['fields'][$aek + 1]['fieldname'] = [explode(':', $file)[0]];
										$action7['fields'][$aek + 1]['extensions'] = !empty(explode(':', $file)[1]) ? explode('-', explode(':', $file)[1]) : [];

										$fields7['files'][explode(':', $file)[0]] = [
											'extensions' => $action7['fields'][$aek + 1]['extensions'],
											'size' => $action7['size'],
											'errors' => $action7['errors'],
											'path' => $action7['path'],
										];
									}

									$action7['type'] = 'generic';
								}

								$form7['functions'][$action_id] = $action7;
							}
						}else{
							if($action == 'css' OR $action == 'js'){
								$units['fields'][] = [
									'type' => $action,
									'content' => $units['actions_config'][$action_id]['content'],
									'files' => $units['actions_config'][$action_id]['files'],
								];
							}

							$action7['type'] = 'generic';
							$form7['functions'][$action_id] = array_merge($units['actions_config'][$action_id], $action7);
						}
					}
				}
			}
		}else{
			$form7['pages'][1] = [
				'pgroup' => 1,
				'minimized' => '0',
				'name' => 'load',
			];
			$form7['pages'][2] = [
				'pgroup' => 1,
				'minimized' => '0',
				'name' => 'submit',
			];
		}

		$types7['views'] = [
			'checkbox' => 'field_checkbox',
			'checkbox_group' => 'field_checkboxes',
			'text' => 'field_text',
			'dropdown' => 'field_select',
			'file' => 'field_file',
			'hidden' => 'field_hidden',
			'password' => 'field_password',
			'radio' => 'field_radios',
			'submit' => 'field_button',
			'button' => 'field_button',
			'reset' => 'field_button',
			'textarea' => 'field_textarea',
			'custom' => 'html_code',
			'css' => 'css',
			'js' => 'javascript',

			'container' => 'area_container',
			'multi' => 'area_fields',
		];

		$types7['views2'] = [
			'captcha' => 'field_secicon',
			'datepicker' => 'field_calendar',
			'recaptcha' => 'gcaptcha',
			'signature_pad' => 'wfield_signature',

			// 'container' => 'container',
			// 'multi' => 'multi',
		];

		$type7_views_map = [
			'name' => ['nodes.main.attrs.name'],
			'value' => ['nodes.main.attrs.value', ['html' => ['field_value_placeholder']]],
			'placeholder' => ['nodes.main.attrs.placeholder', ['html' => ['field_value_placeholder']]],
			'options' => ['multiline_options', ['_' => ['field_multiline_options']]],
			'label.text' => ['nodes.label.content'],
			'sublabel' => ['nodes.help.content', ['html' => ['field_info']]],
			':data-tooltip' => ['nodes.tooltip.attrs.data-hint', ['html' => ['field_info']]],
			'values' => ['multiline_selected'],

			//for css/js
			'content' => ['content'],
			// ':multiple' => ['', ['html' => ['field_multiple']]],
			// 'multiple' => ['', ['html' => ['field_multiple']]],
			':data-inputmask' => ['nodes.main.attrs.data-inputmask', ['_' => ['field_mask']]],
			// 'code' => ['nodes.main.content'],

			
			'validation.required' => [false, ['validation' => ['field_validation_required']]],
			'validation.email' => [false, ['validation' => ['field_validation_email']]],
			'validation.url' => [false, ['validation' => ['field_validation_url']]],
		];

		if(!empty($units['fields'])){
			$inner_fields = [];
			foreach($units['fields'] as $kf => $field){
				if($field['type'] == 'multi' AND !isset($field['render_type'])){
					if(!empty($field['inputs'])){
						foreach($field['inputs'] as $inner){
							$inner['_parent'] = $kf;
							$inner['_area'] = 'body';
							$inner_fields[] = $inner;
						}
					}
				}
			}

			// $units['fields'] = array_merge($units['fields'], $inner_fields);
			foreach($inner_fields as $inner_field){
				$units['fields'][] = $inner_field;
			}

			foreach($units['fields'] as $kf => $field){
				$view7 = [
					'uid' => $kf,
					'_parent' => $field['_parent'] ?? '',
					'_area' => $field['_area'] ?? 1,
					'name' => $field['type'].'_'.$kf,
					'utype' => 'views',
					'behaviors' => []
				];
				if(!empty($field['render_type'])){
					if(!empty($types7['views2'][$field['render_type']])){
						$view7['type'] = $types7['views2'][$field['render_type']];
					}else{
						$view7['type'] = $types7['views'][$field['type']];
					}
				}else{
					$view7['type'] = $types7['views'][$field['type']] ?? '';
				}

				foreach($type7_views_map as $key => $kdata){
					if(strlen(\G3\L\Arr::getVal($field, $key, ''))){
						if(!empty($kdata[0])){
							$view7 = \G3\L\Arr::setVal($view7, $kdata[0], \G3\L\Arr::getVal($field, $key, ''));
						}

						if(!empty($kdata[1])){
							if(isset($kdata[1]['_'])){
								$kdata[1][$view7['type']] = $kdata[1]['_'];
								unset($kdata[1]['_']);
							}
							$view7['behaviors'] = array_merge_recursive($view7['behaviors'], $kdata[1]);
						}
					}
				}

				if(!empty($field['container_id'])){
					$view7['_parent'] = (int)$field['container_id'];
					$view7['_area'] = 'body';
				}

				if($view7['type'] == 'field_button'){
					$view7['nodes']['main']['attrs']['type'] = $field['type'];
					$view7['nodes']['main']['content'] = $field['value'];
				}

				if($view7['type'] == 'wfield_signature'){
					$view7['nodes']['clear']['content'] = 'Clear';
				}

				if($view7['type'] == 'field_textarea'){
					$view7['nodes']['main']['attrs']['rows'] = $field['rows'];
					if(!empty($field[':data-wysiwyg'])){
						$view7['behaviors']['field_textarea'][] = 'field_textarea_editor';
					}
				}

				if($view7['type'] == 'html_code'){
					$view7['nodes']['main']['content'] = $field['code'];
				}

				if($view7['type'] == 'field_text' AND ($view7['nodes']['main']['attrs']['name'] == 'chrono_security_answer')){
					$view7['type'] = 'field_secicon';
				}

				if($view7['type'] == 'field_secicon'){
					$view7['nodes']['label']['content'] = 'Select image of %s';
				}

				if($view7['type'] == 'field_select'){
					if(!empty($field['multiple'])){
						$view7['behaviors']['html'][] = 'field_multiple';
					}
					if(!empty($field['empty'])){
						$view7['multiline_options'] = '='.$field['empty']."\n".$view7['multiline_options'];
						$view7['behaviors']['field_select'][] = 'field_select_clearable';
					}
				}

				if($view7['type'] == 'field_file'){
					if(!empty($field[':multiple'])){
						$view7['behaviors']['html'][] = 'field_multiple';
					}
					if(!empty($field['name']) AND !empty($fields7['files'][$field['name']])){
						$view7['fns']['upload']['fields'][$view7['uid']] = $fields7['files'][$field['name']];

						$view7['behaviors']['data'][] = 'field_upload';
						$view7['behaviors']['data'][] = 'field_attach';
					}
				}

				if($view7['type'] == 'field_checkbox'){
					$view7['nodes']['main']['attrs']['checked'] = !empty($field['checked']) ? 'checked' : '';
				}

				if($view7['type'] == 'area_container'){
					if($field['container_type'] == 'panel' OR $field['container_type'] == 'fieldset'){
						$view7['type'] = 'area_segment';
						$view7['behaviors']['area_segment'][] = 'view_fieldset_label';

						$view7['nodes']['title']['content'] = $field['title'];
						$view7['nodes']['title']['attrs']['class']['style'] = 'ribbon';
					}else{
						$view7['behaviors']['html'][] = 'view_fluid';
					}
				}

				if(!empty($field['params'])){
					$view7['behaviors']['html'][] = 'field_attributes';

					$params = explode("\n", $field['params']);
					foreach($params as $pk => $param){
						$view7['attrs'][$pk + 1]['name'] = trim(explode('=', $param)[0]);
						$view7['attrs'][$pk + 1]['value'] = (count(explode('=', $param)) > 1) ? trim(explode('=', $param)[1]) : trim(explode('=', $param)[0]);
					}
				}

				if(!empty($field['files'])){
					$files = explode("\n", $field['files']);
					foreach($files as $pk => $file){
						$view7['files'][$pk + 1]['url'] = trim($file);
					}
					$view7['behaviors'][$view7['type']][] = 'view_files_list';
				}

				if(!empty($view7['nodes']['main']['attrs']['name'])){
					$view7['nodes']['main']['attrs']['name'] = str_replace('[]', '', $view7['nodes']['main']['attrs']['name']);
					$view7['nodes']['main']['attrs']['name'] = str_replace(['[', ']'], ['.', ''], $view7['nodes']['main']['attrs']['name']);

					$view7['behaviors']['data'][] = 'field_email';
					$view7['behaviors']['data'][] = 'field_dblog';
					$view7['behaviors']['data'][] = 'field_validate';
				}

				// if(!empty($field['validation'])){
				// 	foreach($field['validation'] as $rule => $rstatus){
				// 		if(!empty($rstatus)){

				// 		}
				// 	}
				// }

				$form7['views'][$kf] = $view7;
			}
		}

// pr($form7);

		return $form7;
	}

}