<?php
/**
* ChronoCMS version 1.0
* Copyright (c) 2012 ChronoCMS.com, All rights reserved.
* Author: (ChronoCMS.com Team)
* license: Please read LICENSE.txt
* Visit http://www.ChronoCMS.com for regular updates and information.
**/
namespace G3\H;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
class Message extends \G3\L\Helper{
	
	public static function render($types = array(), $js = false){
		if(!empty($types)){
			$system_messages = array();
			$icons = array('success' => 'check', 'error' => 'cancel', 'info' => 'info', 'warning' => 'warning');
			foreach($types as $type => $messages){
				$list = array();
				$messages = \G3\L\Arr::normalize($messages);
				if(!$js){
					foreach($messages as $message){
						$list[] = '<li>'.$message.'</li>';
					}
					$message_box = '<div class="ui message visible G3-message '.$type.'"><ul class="list header">'.implode("\n", $list).'</ul></div>';
				}else{
					foreach($messages as $message){
						$list [] = "$('body')
							.toast({
								class: '".$type."',
								message: '".$message."'
							})
						;";
					}
					$message_box = '
					<script type="text/javascript">
					jQuery(document).ready(function($){
						'.implode("\n", $list).'
					});
					</script>';
				}

				$system_messages[] = $message_box;
			}
			$system_messages_container = implode("\n", $system_messages);
			return $system_messages_container;
		}
		return '';
	}
}