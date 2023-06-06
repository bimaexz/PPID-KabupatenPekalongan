<?php
/**
* COMPONENT FILE HEADER
**/
namespace G3\A\C;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Installer extends \G3\L\Controller {
	
	function index(){
		//apply updates
		$sql = file_get_contents(\G3\Globals::ext_path($this->extension, 'admin').'sql'.DS.'install.'.$this->extension.'.sql');
		
		$queries = \G3\L\Database::getInstance()->split_sql($sql);
		
		foreach($queries as $query){
			\G3\L\Database::getInstance()->exec(\G3\L\Database::getInstance()->_prefixTable($query, true));
		}
		
		if(method_exists($this, 'update')){
			$this->update();
		}
		
		\GApp3::session()->flash('success', rl3('Database tables have been installed.'));
		
		$this->redirect(r3('index.php?ext='.$this->extension.'&cont=tasks&act=clear_cache'));
	}
	
	/* function update(){
		$Table = new \G3\L\Model(['name' => 'Table', 'table' => '#__chronoengine_forms7']);
		
		$Table->tablefields(true);
		
		$fields =[
			['name' => 'apptype', 'type' => 'varchar', 'length' => 50],
		];
		
		foreach($fields as $field){
			if(!in_array($field['name'], $Table->tablefields)){
				$Table->addField($field['name'], $field);
			}
		}
	} */
}
?>