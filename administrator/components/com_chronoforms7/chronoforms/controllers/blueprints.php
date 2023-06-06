<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\E\Chronoforms\C;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Blueprints extends \G3\A\E\Chronoforms\App {
	use \G3\A\C\T\DataOps;

	var $_libs = array(
		'FData' => '\G3\A\E\Chronoforms\L\Fdata',
		'Parser' => '\G3\A\E\Chronoforms\H\Parser2',
		'Behaviors' => '\G3\A\E\Chronoforms\L\Behaviors',
		// 'Locales' => '\G3\A\E\Chronoforms\L\Locales',
		'Acls' => '\G3\A\E\Chronoforms\L\Acls',
		'Models' => '\G3\A\E\Chronoforms\L\Models',
	);
	
	var $_models = array(
		'\G3\A\E\Chronoforms\M\Connection', 
	);
	
	var $_helpers = array(
		//'Html' => '\G3\H\Html',
		'Field' => '\G3\A\E\Chronoforms\H\Field',
		'Parser' => '\G3\A\E\Chronoforms\H\Parser2',
	);

	function testbp(){
		pr($this->data);
		$this->set('flownodes', $this->data('flownodes', []));
	}

	function bp_unit(){
		// $unit_info_file = \G3\Globals::get('FRONT_PATH').'vendors'.DS.'blueprints'.DS.$this->data('list').DS.$this->data('group').DS.$this->data('name').DS.$this->data('name').'.php';
		// $unit_info = require($unit_info_file);

		// $group_info_file = \G3\Globals::get('FRONT_PATH').'vendors'.DS.'blueprints'.DS.$this->data('list').DS.$this->data('group').DS.$this->data('group').'.php';
		// $group_info = require($group_info_file);

		// $info = array_replace_recursive($group_info, $unit_info);

		// $this->set('info', $info);

		// $nid = $info['name'].$this->data('count');
		// $this->set('nid', $nid);

		// $uid = $this->data('count');
		// $this->set('uid', $uid);

		$this->set('bp_path', \G3\Globals::get('FRONT_PATH').'vendors'.DS.'blueprints'.DS);
		
		$this->set('uid', $this->data('uid'));

		$this->set('flownode', [
			'name' => $this->data('name'),
			'group' => $this->data('group'),
			'list' => $this->data('list'),
		]);
	}

	function bp_unit_edit(){
		$unit_info_file = \G3\Globals::get('FRONT_PATH').'vendors'.DS.'blueprints'.DS.$this->data('list').DS.$this->data('group').DS.$this->data('name').DS.$this->data('name').'.php';
		$unit_info = require($unit_info_file);

		$group_info_file = \G3\Globals::get('FRONT_PATH').'vendors'.DS.'blueprints'.DS.$this->data('list').DS.$this->data('group').DS.$this->data('group').'.php';
		$group_info = require($group_info_file);

		$info = array_replace_recursive($group_info, $unit_info);

		$this->set('info', $info);

		$this->set('uid', $this->data('uid'));

		$unit_config_file = \G3\Globals::get('FRONT_PATH').'vendors'.DS.'blueprints'.DS.$this->data('list').DS.$this->data('group').DS.$this->data('name').DS.$this->data('name').'_config.php';
		
		$this->set('config_file', $unit_config_file);
	}

}
?>