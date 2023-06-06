<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	require_once(\G3\Globals::get('FRONT_PATH').'vendors'.DS.'payments'.DS.'2checkout'.DS.'Twocheckout.php');

	$vendorid = $function['sid'];
	$secretword = $function['secret'];

	if(!empty($function['check_type']) AND ($function['check_type'] == 'return')){
		$passback = \Twocheckout_Return::check($this->data, $secretword);
	}else{
		//default: notification/webhook
		$passback = \Twocheckout_Notification::check($this->data, $secretword);
	}
	
	//if the hash is ok
	// if($md5hash == $this->data('md5_hash')){
	if($passback['response_code'] != 'Success'){
		//switch messages types
		/*switch($this->data('message_type')){
			case 'ORDER_CREATED':
				$this->fevents[$function['name']]['order_created'] = 1;
				break;
			case 'FRAUD_STATUS_CHANGED':
				$this->fevents[$function['name']]['fraud_status_changed'] = 1;
				break;
			case 'REFUND_ISSUED':
				$this->fevents[$function['name']]['refund_issued'] = 1;
				break;
			default:
				$this->fevents[$function['name']]['other'] = 1;
				break;
		}*/
		if(!empty($this->data('message_type'))){
			$this->fevents[$function['name']][strtolower($this->data('message_type'))] = 1;
		}
	}else{
		$this->fevents[$function['name']]['fail'] = 1;
	}