<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	if(!empty($function['url'])){
		
		$url = $this->Parser->parse(trim($function['url']));
		
		$data = [];
		
		if(!empty($function['parameters'])){
			foreach($function['parameters'] as $parameter){
				$data[$parameter['name']] = $this->Parser->parse($parameter['value']);
			}
		}
		
		$query = http_build_query($data);
		$query = urldecode($query);
		
		$this->debug[$function['name']]['url'] = $url;
		$this->debug[$function['name']]['query'] = $query;
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, (int)$function['header']);// set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);// Returns response data instead of TRUE(1)

		if(!isset($function['post']) OR !empty($function['post'])){
			curl_setopt($ch, CURLOPT_POSTFIELDS, $query);// use HTTP POST to send form data
		}
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		$response = curl_exec($ch);//execute post and get results
		
		$this->debug[$function['name']]['errors'] = curl_error($ch);
		$curlInfo = curl_getinfo($ch);

		$this->debug[$function['name']]['info'] = print_r($curlInfo, true);
		
		curl_close($ch);
		
		$this->set($function['name'], $response);

		if($curlInfo['http_code'] == 200){
			$this->fevents[$function['name']]['success'] = true;
		}else{
			$this->fevents[$function['name']]['fail'] = true;
		}
	}else{
		$this->debug[$function['name']]['_error'] = rl3('No URL is provided.');
		$this->set($function['name'], false);
		$this->fevents[$function['name']]['fail'] = true;
	}