<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	$icons = [
		['icon' => 'moon', 'text' => 'The Moon'],
		['icon' => 'flag', 'text' => 'The Flag'],
		['icon' => 'soccer', 'text' => 'The Football'],
		['icon' => 'fish', 'text' => 'The Fish'],
		['icon' => 'cat', 'text' => 'The Cat'],
		['icon' => 'dog', 'text' => 'The Dog'],
		['icon' => 'heart', 'text' => 'The Heart'],
		['icon' => 'fruit-apple', 'text' => 'The Apple'],
		['icon' => 'cloud', 'text' => 'The Cloud'],
		['icon' => 'coffee', 'text' => 'The Coffee'],
		['icon' => 'phone', 'text' => 'The Phone'],
	];
	$images = $this->get('cf_settings.secicon.icons', $icons);
	shuffle($images);
	shuffle($images);
	shuffle($images);
	
	$list = array_slice($images, 0, (int)($view['number'] ?? 5));
	$theone = rand(0, ((int)($view['number'] ?? 5)) - 1);
	
	$view['nodes']['label']['content'] = sprintf($view['nodes']['label']['content'], $this->controller->Parser->parse($list[$theone]['text']));
	
	$options = [];
	
	foreach($list as $k => $item){
		$val = uniqid();
		if($k == $theone){
			\GApp3::session()->set('secicon/'.$view['nodes']['main']['attrs']['name'], $val);
		}
		$options[] = ['value' => $val, 'content' => '<i class="faicon '.$item['icon'].' large"></i>'];
	}
	
	$view['foptions'] = $options;
	
	echo $this->Field->buildMulti($view, 'radio');