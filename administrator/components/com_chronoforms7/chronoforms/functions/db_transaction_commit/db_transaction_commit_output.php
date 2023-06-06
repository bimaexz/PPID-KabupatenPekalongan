<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$dbo = \G3\L\Database::getInstance();
	$result = (bool)$dbo->execute_query('COMMIT');

	if($result){
		$this->set($function['name'], $result);
		$this->fevents[$function['name']]['success'] = true;
		$this->debug[$function['name']]['result'] = rl3('Queries committed successfully!');
	}else{
		$this->set($function['name'], $result);
		$this->fevents[$function['name']]['fail'] = true;
		$this->debug[$function['name']]['result'] = rl3('Queries commit failed!');
	}