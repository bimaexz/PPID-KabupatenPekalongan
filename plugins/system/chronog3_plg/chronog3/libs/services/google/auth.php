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
class Auth {

	public static function getToken($settings){
		$settings = [
			'token' => $settings['token'], 
			'credentials' => $settings['credentials'], 
			'scopes' => self::updateScopes($settings['scopes']), 
			'redirect_uri' => $settings['redirect_uri'] ?? r3(\G3\Globals::get('ROOT_URL').'index.php?chronoservice=google.oauth'),
			'listener_uri' => $settings['listener_uri'] ?? \G3\L\Url::current(),
			'refresh' => $settings['refresh'] ?? false,
		];
		foreach($settings as $key => $value){
			$$key = $value;
		}
		// if(!empty(\GApp3::session()->get('services.google.accessToken'))){
		// 	$token = \GApp3::session()->get('services.google.accessToken');
		// 	$tscopes = explode(' ', $token['scope']);
		// 	if(empty(array_diff($scopes, $tscopes))){
		// 		return \GApp3::session()->get('services.google.accessToken');
		// 	}
		// }
		if(!empty($token) AND !$refresh){
			if(is_string($token)){
				if(strpos($token, '{') === 0){
					$token = json_decode($token, true);
				}
			}
			$tscopes = explode(' ', $token['scope']);
			if(empty(array_diff($scopes, $tscopes))){
				return $token;
			}
		}

		require_once(\G3\Globals::get('FRONT_PATH').'vendors'.DS.'google'.DS.'vendor'.DS.'autoload.php');
		
		$client = new \Google_Client();

		$client->setClientId($credentials['id']);
		$client->setClientSecret($credentials['secret']);

		$client->setRedirectUri($redirect_uri);
		// $client->setRedirectUri(r3(\G3\Globals::get('ROOT_URL').'index.php?chronoservice=google.oauth'));
		
		$client->setAccessType('offline');
		$client->setIncludeGrantedScopes(true);
		$client->addScope($scopes);

		if(empty($_GET['code'])){
			$requestId = rand(11111, 99999);
			$client->setState(json_encode([
				'requestid' => $requestId,
				'url' => $listener_uri,
			]));
			\GApp3::session()->set('services.google.requestId', $requestId);
			\GApp3::session()->set('services.google.source_uri', $listener_uri);
			// \GApp3::session()->set('services.google.credentials', $credentials);
		}

		if(!empty($_GET['code']) AND !empty($_GET['requestid']) AND ($_GET['requestid'] == \GApp3::session()->set('services.google.requestId'))){
			$client->authenticate($_GET['code']);
			$accessToken = $client->getAccessToken();
			// \GApp3::session()->set('services.google.accessToken', $accessToken);
			return $accessToken;
		}elseif(!empty($_GET['error'])){
			return false;
		}else{
			$auth_url = $client->createAuthUrl();
			\GApp3::redirect($auth_url);
		}
	}
	
	public static function httpClient($settings){
		$settings = [
			'token' => $settings['token'], 
			'credentials' => $settings['credentials'], 
			'scopes' => self::updateScopes($settings['scopes']), 
			'redirect_uri' => $settings['redirect_uri'] ?? r3(\G3\Globals::get('ROOT_URL').'index.php?chronoservice=google.oauth'),
			'listener_uri' => $settings['listener_uri'] ?? \G3\L\Url::current(),
		];
		foreach($settings as $key => $value){
			$$key = $value;
		}

		if(is_string($token)){
			if(strpos($token, '{') === 0){
				$token = json_decode($token, true);
			}
		}

		if(!empty($redirect_uri)){
			if(empty($token)){
				$token = self::getToken($settings);
			}else{
				if(!empty($scopes)){
					$tscopes = explode(' ', $token['scope']);
					if(!empty(array_diff($scopes, $tscopes))){
						$token = self::getToken($settings);
					}
				}
			}
		}

		require_once(\G3\Globals::get('FRONT_PATH').'vendors'.DS.'google'.DS.'vendor'.DS.'autoload.php');
		
		$client = new \Google_Client();
		
		if(is_string($token) AND file_exists($token)){
			putenv('GOOGLE_APPLICATION_CREDENTIALS='.$token);
			$client->useApplicationDefaultCredentials();
			$client->addScope($scopes);
		}else{
			$client->setClientId($credentials['id']);
			$client->setClientSecret($credentials['secret']);
			$client->setAccessToken($token);
		}
		
		$httpClient = $client->authorize();

		return $httpClient;
	}

	private static function updateScopes($scopes){
		$return = [];
		foreach($scopes as $scope){
			if(strpos($scope, 'https://') === false){
				$return[] = 'https://www.googleapis.com/auth/'.$scope;
			}else{
				$return[] = $scope;
			}
		}

		return $return;
	}
}