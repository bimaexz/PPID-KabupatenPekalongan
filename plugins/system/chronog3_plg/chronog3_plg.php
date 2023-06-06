<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
class PlgSystemChronog3_Plg extends JPlugin{
	var $output = '';
	var $active = true;
	
	public function onAfterRoute(){
		if(!defined('DS')){
			define('DS', DIRECTORY_SEPARATOR);
		}

		$app = JFactory::getApplication();
		
		if(version_compare(PHP_VERSION, '7.0.0') >= 0){
			
		}else{
			$this->active = false;
			return;
		}
		
		if($app->isClient('administrator')){
			defined('GCORE_SITE') or define('GCORE_SITE', 'admin');
		}else{
			defined('GCORE_SITE') or define('GCORE_SITE', 'front');
		}
		
		// jimport('chronog3.gcloader');
		require_once(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'chronog3_plg'.DS.'chronog3'.DS.'gcloader.php');
		if(!class_exists('\G3\Loader')){
			JError::raiseWarning(100, 'The CEGCore3 library could not be found.');
			$this->active = false;
		}
		
		if($this->active){
			\G3\L\AppLoader::initialize();
			if(\G3\L\Request::data('chronoservice') == 'google.oauth'){
				if(!empty(\G3\L\Request::data('state'))){
					$url = json_decode(\G3\L\Request::data('state'), true)['url'];
					$url = \G3\L\Url::build($url, [
						'code' => $_GET['code'] ?? '',
						'authuser' => $_GET['authuser'] ?? '',
						'error' => $_GET['error'] ?? '',
						'requestid' => json_decode(\G3\L\Request::data('state'), true)['requestid'],
					]);
					
					\GApp3::redirect($url);
				}
			}
			if(!\G3\Globals::site('admin')){
				// \G3\L\AppLoader::initialize();

				$system_test_option = function($rule){
					return (\G3\L\Request::data($rule['first']) == $rule['second']);
				};

				$settings = \GApp3::extension('chronoforms')->settings()->data;
				if(!empty($settings['system']['url_conditions'])){
					$conditions = $settings['system']['url_conditions'];

					foreach($conditions as $condition){
						$condition_result = true;

						if(!empty($condition['rules'])){
							foreach($condition['rules'] as $rule){
								if(empty($condition['logic']) OR $condition['logic'] == 'and'){
									$condition_result = ($condition_result AND $system_test_option($rule));
								}elseif(!empty($condition['logic']) AND $condition['logic'] == 'or'){
									$condition_result = $system_test_option($rule);
									if($condition_result){
										break;
									}
								}
							}
							
							if($condition_result){
								parse_str($condition['params'], $params);
								
								foreach($params as $pkey => $pval){
									$_GET[$pkey] = $_REQUEST[$pkey] = $pval;
									\G3\L\Request::set($pkey, $pval, true);
								}
							}
						}
					}
				}
				
				//clean content cache if chronoforms7 plugin code exists
				/*if(!empty($_REQUEST['option']) AND $_REQUEST['option'] == 'com_content' AND !empty($_REQUEST['id'])){
					$cache = JFactory::getCache('com_content');
					$model = new \G3\L\Model(['name' => 'Article', 'table' => '#__content']);
					$model->where('id', $_REQUEST['id']);
					$article = $model->select('first');
					
					if(!empty($article)){
						if(strpos($article['Article']['introtext'], '{chronoforms7}') !== false OR strpos($article['Article']['fulltext'], '{chronoforms7}') !== false){
							$cache->clean('com_content');
						}
					}
				}*/
			}
		}
	}
	
	public function onAfterDispatch(){
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		$buffer = $doc->getBuffer('component');
		
		if($this->active){
			\G3\L\AppLoader::initialize();
			
			$components = ['com_content'];

			$settings = \GApp3::extension('chronoforms')->settings()->data;
			if(!empty($settings['system']['shortcode']['components'])){
				$components = $settings['system']['shortcode']['components'];
			}
			
			//if(!\G3\Globals::site('admin') AND in_array(\G3\L\Request::data('option'), $components) AND \G3\L\Request::data('layout') != 'edit'){
			if(!\G3\Globals::site('admin') AND in_array($app->input->get('option'), $components) AND $app->input->get('layout') != 'edit'){
				//match shortcodes
				$regexes = [
					'chronomarket' => '#{chronomarket}(.*?){/chronomarket}#s',
					'chronoforms7' => '#{chronoforms7}(.*?){/chronoforms7}#s',
				];
				
				$reg_capture = [
					'chronoforms7' => ['chronoform', 'gpage'],
				];
				
				$reg_matches = [
					'chronoforms7' => ['chronoform'],
				];
				
				$reg_resets = [
					'chronoforms7' => ['chronoform' => ['gpage']],
				];
				
				$reg_values = [];
				
				//$adata = \G3\L\Request::raw();
				
				foreach($regexes as $ext => $regex){
					preg_match_all($regex, $buffer, $matches);
					
					if(!empty($reg_capture[$ext])){
						foreach($reg_capture[$ext] as $rck => $rcv){
							$reg_values[$rcv] = \G3\L\Request::data($rcv);
						}
					}
					
					if(!empty($matches[0])){
						foreach($matches[0] as $k => $match){
							ob_start();
							$ext_path = JPATH_SITE.DS.'components'.DS.'com_'.$ext.DS.$ext.'.php';
							if(file_exists($ext_path)){
								//check params
								if(!empty($matches[1][$k])){
									parse_str(html_entity_decode($matches[1][$k]), $params);
									
									if(!empty($reg_matches[$ext])){
										$params_keys = array_keys($params);
										foreach($reg_matches[$ext] as $rk => $rv){
											//\G3\L\Request::set($rv, $params_keys[$rk]);
											if(!empty($reg_values[$rv]) AND $reg_values[$rv] != $params_keys[$rk]){
												if(!empty($reg_resets[$ext][$rv])){
													foreach($reg_resets[$ext][$rv] as $rskey){
														\G3\L\Request::set($rskey, null);
													}
												}
											}else{
												if(!empty($reg_resets[$ext][$rv])){
													foreach($reg_resets[$ext][$rv] as $rskey){
														\G3\L\Request::set($rskey, $reg_values[$rskey]);
													}
												}
											}
											
											\G3\L\Request::set($rv, $params_keys[$rk]);
										}
									}
									
									foreach($params as $pk => $pv){
										if(!is_null($pv)){
											\G3\L\Request::set($pk, $pv);
										}
									}
								}
								
								require($ext_path);
								$result = ob_get_clean();
								$buffer = str_replace($match, $result, $buffer);
							}
						}
					}
				}
				
				$doc->setBuffer($buffer, 'component');
			}
		}
	}
	
	// public function onBeforeCompileHead(){
	// 	if(class_exists('GApp3')){
	// 		$doc = \GApp3::document();
	// 		$doc->buildHeader();
	// 	}
	// }

	public function onAfterRender(){
		$app = JFactory::getApplication();
		$doc = \GApp3::document();

		$html = $app->getBody();
		
		$html = str_replace('</head>', $doc->buildMediaOutput().'</head>', $html);
		$app->setBody($html);
	}
}
