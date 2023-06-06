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
class Sheets extends \G3\L\Services\Google\Service{
	CONST UPDATE_FAILED = 1;

	public function append($settings, $data){
		$settings['sheet'] = 'Sheet1';
		$valueRange = [
			'range' => $settings['sheet'],
			'majorDimension' => 'ROWS',
			'values' => $data,
		];
		
		$response = $this->httpClient->request('POST', 'https://sheets.googleapis.com/v4/spreadsheets/'.$settings['spreadsheet_id'].'/values/'.$settings['sheet'].':append?valueInputOption=USER_ENTERED', [
			'headers' => ['Content-Type' => 'application/json'],
			'body' => json_encode($valueRange),
		]);
		
		$responseData = json_decode($response->getBody(), true);
		
		if($response->getStatusCode() == 200){
			$this->msgs[]['appended'] = rl3('Data has been appended to the sheet successfully!');
			return $responseData;
		}else{
			$this->status = self::UPDATE_FAILED;
			$this->errors[] = rl3('Failed appending data!');
			return;
		}
	}
}