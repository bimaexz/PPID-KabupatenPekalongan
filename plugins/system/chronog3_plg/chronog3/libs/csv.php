<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\L;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Csv {
	
	public static function build($lines, $delimiter, $action = 'D', $path = false, &$saved = null){
		@error_reporting(0);

		$csv_output = function($data, $delimiter){
			$outstream = fopen('php://output', 'w');
			fprintf($outstream, chr(0xEF).chr(0xBB).chr(0xBF));
			
			array_walk($data, 
			function(&$vals, $key, $filehandler) use ($delimiter){
				fputcsv($filehandler, $vals, $delimiter);
			}, $outstream);
			
			fclose($outstream);
		};
		
		ob_start();
		$csv_output($lines, $delimiter);
		$file_data = ob_get_clean();
		
		if(in_array($action, ['S', 'SD'])){
			$saved = \G3\L\File::write($path, $file_data);
		}
		
		if(in_array($action, ['D', 'SD'])){
			@ob_end_clean();
			
			header('Content-type: text/csv');
			header('Content-Disposition: attachment; filename='.basename($path));
			header('Pragma: no-cache');
			header('Expires: 0');
			
			echo $file_data;
			
			exit;
		}
	}	
}