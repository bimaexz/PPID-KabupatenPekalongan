<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\E\Chronoforms;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Chronoforms extends \G3\A\E\Chronoforms\App {
	var $_libs = array(
		'Behaviors' => '\G3\A\E\Chronoforms\L\Behaviors',
	);
	
	use \G3\A\C\T\Feature {
		installFeature as install_feature;
	}
	
	function index(){
		$this->redirect(r3('index.php?ext=chronoforms&cont=connections'));
	}
	
	function info(){
		
	}
}
?>