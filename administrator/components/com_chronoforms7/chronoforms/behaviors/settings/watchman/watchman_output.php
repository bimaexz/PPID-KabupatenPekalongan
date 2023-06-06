<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$failed = false;
	
	if(!empty($unit['watchman']['mindate'])){
		if(\G3\L\Dater::strtotime($unit['watchman']['mindate'], 'site') > \G3\L\Dater::datetime('U', 'now', 'site')){
			$failed = true;
		}
	}

	if(!empty($unit['watchman']['maxdate'])){
		if(\G3\L\Dater::strtotime($unit['watchman']['maxdate'], 'site') < \G3\L\Dater::datetime('U', 'now', 'site')){
			$failed = true;
		}
	}

	if(!empty($unit['watchman']['offdays'])){
		if(in_array(\G3\L\Dater::datetime('w', 'now', 'site'), $unit['watchman']['offdays'])){
			$failed = true;
		}
	}

	if(!empty($unit['watchman']['offhours'])){
		if(in_array(\G3\L\Dater::datetime('G', 'now', 'site'), $unit['watchman']['offhours'])){
			$failed = true;
		}
	}

	if(!empty($unit['watchman']['maxcount'])){
		$Log = new \G3\A\E\Chronoforms\M\Datalog();
		$count = $Log->where('form_id', $this->controller->FData->cdata('id'))->select('count');
		if($count >= (int)$unit['watchman']['maxcount']){
			$failed = true;
		}
	}

	if(!empty($unit['watchman']['usercount'])){
		$Log = new \G3\A\E\Chronoforms\M\Datalog();
		$count = $Log->where('form_id', $this->controller->FData->cdata('id'))->where('user_id', \GApp3::user()->get('id'))->select('count');
		if($count >= (int)$unit['watchman']['usercount']){
			$failed = true;
		}
	}

	if(!empty($unit['watchman']['ips']['closed'])){
		$ips = array_map('trim', explode("\n", $unit['watchman']['ips']['closed']));
		foreach($ips as $ip){
			if(strpos($_SERVER['REMOTE_ADDR'], $ip) === 0){
				$failed = true;
			}
		}
	}

	if($failed){
		if(!empty($unit['watchman']['page'])){
			$tpage = $this->controller->FData->cdata('pages.'.$unit['watchman']['page'].'.urlname');
			
			$this->set('gpage', $tpage);
		}else{
			\GApp3::redirect(r3('index.php?ext=chronoforms&cont=manager&act=closed'));
		}
	}