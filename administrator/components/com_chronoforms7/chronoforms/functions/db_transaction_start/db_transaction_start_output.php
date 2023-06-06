<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$dbo = \G3\L\Database::getInstance();
	$result = $dbo->execute_query('START TRANSACTION');

	if($result){
		$this->set($function['name'], $result);
		$this->fevents[$function['name']]['success'] = true;
		$this->debug[$function['name']]['result'] = rl3('Trasnaction start is successfull!');
	}else{
		$this->set($function['name'], $result);
		$this->fevents[$function['name']]['fail'] = true;
		$this->debug[$function['name']]['result'] = rl3('Transaction start has failed!');
	}