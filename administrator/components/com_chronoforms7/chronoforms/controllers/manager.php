<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\E\Chronoforms\C;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Manager extends \G3\L\Controller {
	use \G3\A\C\T\Paginate;
	use \G3\A\C\T\Order;
	use \G3\A\C\T\Search;
	
	var $_libs = array(
		'FData' => '\G3\A\E\Chronoforms\L\Fdata',
		'Page' => '\G3\A\E\Chronoforms\L\Page',
		'Parser' => '\G3\A\E\Chronoforms\H\Parser2',
		'Behaviors' => '\G3\A\E\Chronoforms\L\Behaviors',
		'Models' => '\G3\A\E\Chronoforms\L\Models',
	);
	var $_models = array(
		'\G3\A\E\Chronoforms\M\Connection',
		// '\G3\A\E\Chronoforms\M\Block',
		// '\G3\A\E\Chronoforms\M\Locale',
		// '\G3\A\M\Acl',
		//'\G3\A\E\Chronoforms\M\Behavior',
	);
	var $_helpers = array(
		'Html' => '\G3\H\Html',
		'Parser' => '\G3\A\E\Chronoforms\H\Parser2',
		'Field' => '\G3\A\E\Chronoforms\H\Field',
		'Paginator' => '\G3\H\Paginator',
		'Sorter' => '\G3\H\Sorter',
	);

	//var $Parser;
	var $form;
	
	
	function _initialize(){
		//$this->layout('default');
		$this->set('cf_settings', \GApp3::extension('chronoforms')->settings()->data);
	}

	function _read(){
		$conn = $this->get('chronoform', $this->data('chronoform'));
		
		if(empty($conn)){
			return ['error' => rl3('Error, form alias is empty!')];
		}
		
		$this->form = $this->Connection->where('alias', $conn, '= BINARY')->where('published', 1)->order(['id' => 'desc'])->select('first', ['json' => ['pgroups', 'pages', 'views', 'functions', 'settings']]);
		
		if(empty($this->form)){
			if(!empty($this->get('cf_settings.legacy', ['cf5']))){
				$dbo = \G3\L\Database::getInstance();
				$db_tables = $dbo->getTablesList();

				foreach($this->get('cf_settings.legacy', ['cf5']) as $ver){
					if($ver == 'cf5' AND $dbo->tableExists('#__chronoengine_chronoforms')){
						$Table = new \G3\L\Model(['name' => 'Connection', 'table' => '#__chronoengine_chronoforms', 'dbo' => $dbo]);
						$form = $Table->where('title', $conn, '= BINARY')->where('published', 1)->order(['id' => 'desc'])->select('first', ['json' => ['params']]);

						if(!empty($form)){
							$this->form['Connection'] = \G3\A\E\Chronoforms\L\Converter::cf5($form);
						}
					}
				}
			}

			if(empty($this->form)){
				return ['error' => rl3('Error, form does not exist or is not published.')];
			}
		}

		$this->Page->Parser = $this->Parser;
		$this->FData->build($this->form['Connection']);

		return true;
	}
	
	function index(){
		if(\GApp3::instance()->site == 'front'){
			if(!\GApp3::extension('chronoforms')->valid()){
				$this->set('__invalid', true);
			}
		}
		
		$found = $this->_read();

		if($found !== true){
			return $found;
		}

		// pr($this->FData->appdata());
		// pr($this->FData->cdata());
		// pr3($this->FData->sessiondata());
		
		if($this->FData->sessiondata('pages.requested')){
			$page_to_display = $this->FData->sessiondata('pages.requested');
			if($this->FData->sessiondata('pages.requested') == null){
				$page_to_display = $this->FData->sessiondata('pages.default');
			}
			
			$event_output = $this->Page->event($page_to_display);
			
			$display = [];
			if($this->FData->sessiondata('pages.active')){
				$display['sections'] = [$this->FData->sessiondata('pages.active')];
			}

			if(!empty($this->data('uid'))){
				$display['views'] = [$this->FData->cdata('views.'.$this->data('uid'))];
			}

			$this->set('event_output', $event_output);
			$this->set('display', $display);

			$this->view = [
				'views' => [
					'site' => 'admin',
					'cont' => 'manager',
					'act' => 'event',
				]
			];
			
		}else{
			$this->view = false;
		}

		// pr3($this->FData->sessiondata());
		if($this->get('cf_settings.debug.dev_mode', false)){
			$this->set('__dev__', $this->FData->sessiondata());
		}

		if(!empty($this->Page->errors)){
			\GApp3::session()->flash('error', $this->Page->errors);
		}
		
		if(!empty($this->Page->messages)){
			foreach($this->Page->messages as $type => $messages){
				\GApp3::session()->flash($type, $messages);
			}
		}
		
		// if(\GApp3::instance()->site == 'front'){
		// 	if(!\GApp3::extension('chronoforms')->valid()){
		// 		$this->set('__invalid', true);
		// 	}
		// }
		
		// $this->_helpers['Parser'] = $this->Parser;

		//$this->view = false;
	}

	function e403(){
		\GApp3::message('error', rl3('You do not have enough permissions to access this resource.'));
	}

	function closed(){
		\GApp3::message('info', rl3('This page is currently unavailable!'));
	}
	
	function _finalize(){
		if(empty($this->data('dtask')) AND empty($this->tvout) AND \GApp3::extension('chronoforms')->valid() == false){
			if(false AND \G3\Globals::get('app') != 'wordpress'){
				echo '<a href="http://www.chronoengine.com/" target="_blank" class="chronoforms7_credits">Form by ChronoForms - ChronoEngine.com</a>';
			}else{
				echo '<h3>This form was created by ChronoForms</h3>';
			}
		}
	}



	
}
?>