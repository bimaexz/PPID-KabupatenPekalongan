<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$code = '';
	$first = '';

	if(!empty($function['code'])){
		$dbo = \G3\L\Database::getInstance();
		
		if(!empty($function['models']['data']['dbo'])){
			$dbo = \G3\L\Database::getInstance($function['models']['data']['dbo']);
		}
		
		ob_start();
		eval('?>'.$function['code']);
		$code = ob_get_clean();

		$code = trim($code);
		
		$code = $this->Parser->parse($code);

		$first = strtolower(explode(' ', $code)[0]);

		$dbo->adapter->setQuery($code);

		if($first == 'select'){
			$result = $dbo->adapter->loadAssocList();
		}elseif($first == 'insert' OR $first == 'update'){
			$result = $dbo->adapter->query();
		}else{
			if($dbo->adapter->query()){
				$result = $dbo->adapter->getAffectedRows();
			}else{
				$result = false;
			}
		}
	}

	if($result){
		$this->set($function['name'], $result);
		$this->fevents[$function['name']]['success'] = true;
		$this->debug[$function['name']]['result'] = rl3('SQL processed successfully!');
	}else{
		$this->set($function['name'], $result);
		$this->fevents[$function['name']]['fail'] = true;
		$this->debug[$function['name']]['result'] = rl3('SQL failed processing!');
	}

	$this->debug[$function['name']]['sql'] = $code;
	$this->debug[$function['name']]['mode'] = $first;