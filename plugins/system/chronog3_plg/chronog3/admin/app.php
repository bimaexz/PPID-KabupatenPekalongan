<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class App extends \G3\L\Controller {
	use \G3\A\C\T\Update;
	use \G3\A\C\T\Paginate;
	use \G3\A\C\T\Order;
	use \G3\A\C\T\Search;
	use \G3\A\C\T\Record;
	
	function _initialize(){
		$this->_helpers[] = '\G3\H\Html';
		
		$this->sqlUpdate();
		$this->layout('default');
	}
	
}
?>