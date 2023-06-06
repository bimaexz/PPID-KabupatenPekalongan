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
class Drive extends \G3\L\Services\Google\Service{
	CONST REQUEST_FAILED = 1;
	CONST UPLOAD_FAILED = 2;

	public function create($metadata, $folder = false){
		if($folder){
			$metadata['mimeType'] = 'application/vnd.google-apps.folder';
		}
		try{
			$response = $this->httpClient->request('POST', 'https://www.googleapis.com/drive/v3/files', [
				'headers' => [
					'Content-Type'     => 'application/json; charset=UTF-8',
					'Content-Length'      => strlen(json_encode($metadata)),
				],
				'body' => json_encode($metadata),
			]);
		}catch(RequestException $e){
			$this->status = REQUEST_FAILED;
			$this->errors[] = rl3('Failed creating file entry on Google Drive');
			$this->msgs[] = json_decode($response->getBody(), true);
			return;
		}

		// if($response->getStatusCode() == 200){
		// 	$this->msgs[]['file_upload_url'] = $response->getHeaderLine('Location');
		// }else{
		// 	$this->status = REQUEST_FAILED;
		// 	$this->errors[] = rl3('Failed creating file entry on Google Drive');
		// 	$this->msgs[] = json_decode($response->getBody(), true);
		// 	return;
		// }
		// pr3($response);
		// pr3((string) $response->getBody());

		$newfilemeta = json_decode($response->getBody(), true);
		
		return $newfilemeta;
	}

	public function upload($metadata, $filedata){
		try{
			$response = $this->httpClient->request('POST', 'https://www.googleapis.com/upload/drive/v3/files?uploadType=resumable', [
				'headers' => [
					'Content-Type'     => 'application/json; charset=UTF-8',
					'Content-Length'      => strlen(json_encode($metadata)),
				],
				'body' => json_encode($metadata),
			]);
		}catch(RequestException $e){
			$this->status = REQUEST_FAILED;
			$this->errors[] = rl3('Failed creating file entry on Google Drive');
			$this->msgs[] = json_decode($response->getBody(), true);
			return;
		}

		if($response->getStatusCode() == 200){
			$this->msgs[]['file_upload_url'] = $response->getHeaderLine('Location');
		}else{
			$this->status = REQUEST_FAILED;
			$this->errors[] = rl3('Failed creating file entry on Google Drive');
			$this->msgs[] = json_decode($response->getBody(), true);
			return;
		}
		
		$response = $this->httpClient->request('PUT', $response->getHeaderLine('Location'), [
			'headers' => [
				'Content-Length' => is_string($filedata) ? strlen($filedata) : 1,
			],
			'body' => $filedata,
		]);

		if($response->getStatusCode() == 200){
			$this->msgs[]['file_data'] = rl3('File data uploaded successfully to Google drive');
		}else{
			$this->status = UPLOAD_FAILED;
			$this->errors[] = rl3('Failed upload file data on Google Drive');
			return;
		}
		// pr3($response);
		// pr3((string) $response->getBody());

		$newfilemeta = json_decode($response->getBody(), true);
		$newfilemeta['dlink'] = 'https://drive.google.com/uc?id='.$newfilemeta['id'].'&export=download';
		$newfilemeta['vlink'] = 'https://drive.google.com/file/d/'.$newfilemeta['id'].'/view?usp=drivesdk';
		
		return $newfilemeta;
	}

	public function list($fileId = ''){
		$response = $this->httpClient->request('GET', 'https://www.googleapis.com/drive/v3/files');
		if($response->getStatusCode() == 200){
			return json_decode($response->getBody(), true);
		}else{
			$this->status = UPLOAD_FAILED;
			$this->errors[] = rl3('Failed reading files on Google Drive');
			return;
		}
	}

	public function metadata($fileId){
		$response = $this->httpClient->request('GET', 'https://www.googleapis.com/drive/v3/files/'.$fileId.'?fields=*');
		if($response->getStatusCode() == 200){
			return json_decode($response->getBody(), true);
		}else{
			$this->status = UPLOAD_FAILED;
			$this->errors[] = rl3('Failed reading file meta on Google Drive');
			return;
		}
	}

	public function create_permission($fileId, $presource = ['role' => 'writer', 'type' => 'user', 'emailAddress' => 'address@gmail.com']){
		$response = $this->httpClient->request('POST', 'https://www.googleapis.com/drive/v3/files/'.$fileId.'/permissions', [
			'headers' => ['Content-Type' => 'application/json'],
			'body' => json_encode($presource),
		]);
		if($response->getStatusCode() == 200){
			$this->msgs[]['file_permissions'] = rl3('File permissions updated successfully on Google drive');
		}else{
			$this->status = UPLOAD_FAILED;
			$this->errors[] = rl3('Failed updating file permissions on Google Drive');
			return;
		}
	}
}