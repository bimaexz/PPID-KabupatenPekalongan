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
class User extends \G3\L\Services\Google\Service{
	CONST REQUEST_FAILED = 1;

	var $scopes = ['userinfo.profile'];

	public function info(){
		try{
			$response = $this->httpClient->request('GET', 'https://www.googleapis.com/oauth2/v3/userinfo');
		}catch(RequestException $e){
			$this->status = self::REQUEST_FAILED;
			return;
		}

		if($response->getStatusCode() == 200){
			return json_decode($response->getBody(), true);
		}else{
			$this->status = self::REQUEST_FAILED;
			return;
		}
	}
}