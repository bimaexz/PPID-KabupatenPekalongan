<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\L\Services\Google;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Tts extends \G3\L\Services\Google\Service{
	CONST SYNTHESIZE_FAILED = 1;

	public function synthesize($settings){
		$data = array_replace_recursive([
			'voice' => ['languageCode' => 'en-GB'],
			'audioConfig' => ['audioEncoding' => 'MP3'],
		], $settings);
		
		$response = $this->httpClient->request('POST', 'https://texttospeech.googleapis.com/v1beta1/text:synthesize', [
			'headers' => ['Content-Type' => 'application/json'],
			'body' => json_encode($data),
		]);
		
		$responseData = json_decode($response->getBody(), true);

		if($response->getStatusCode() == 200){
			$this->msgs[]['text_synthesized'] = rl3('Text has been converted to Audio successfully');
			return $responseData;
		}else{
			$this->status = self::SYNTHESIZE_FAILED;
			$this->errors[] = rl3('Failed audio conversion');
			return;
		}
	}
}