<?php
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;
?>
<?php
	
	$_result = false;
	
	// if(!empty($function['recipients']) AND !empty($function['subject']) AND (!empty($function['body']) OR !empty($function['autoemail']))){
	if(true){
		$mailer = new \G3\L\Mail();
		
		$function['recipients'] = !empty($function['recipients']) ? $function['recipients'] : $this->get('cf_settings.email.recipients');

		$addresses = $function['recipients'];
		
		$recipients = [];
		foreach($addresses as $address){
			if(!empty($address)){
				$recipients[] = $this->Parser->parsev(trim($address), 'email_params');
			}
		}
		
		$recipients = array_unique(\G3\L\Arr::flatten($recipients));
		
		$this->debug[$function['name']]['recipients'] = $recipients;

		$function['subject'] = !empty($function['subject']) ? $function['subject'] : $this->get('cf_settings.email.subject');
		
		$subject = $this->Parser->parse($function['subject']);
		
		$this->debug[$function['name']]['subject'] = $subject;
		
		if(!empty($function['units'])){
			$auto = $this->Parser->dataList($function['units']);

			if(!empty($function['body'])){
				$function['body'] = str_replace('{email_content}', $auto, $function['body']);
			}else{
				$function['body'] = $auto;
			}
			
			// $function['body'] = $function['body']."\n".'{summary.email:*}';
		}
		
		$body = $this->Parser->parse($function['body']);

		if(\GApp3::extension('chronoforms')->valid() == false){
			$body .= '<br><br>This email was sent by <a target="_blank" href="https://www.chronoengine.com/">ChronoForms7</a>';
		}
		
		$this->debug[$function['name']]['body'] = $body;
		
		$mailer->mode = $function['mode'] ?? 'html';
		
		if(false AND !empty($function['advanced_template'])){
			$body = $mailer->prepareContent($body);
		}
		
		if(empty($function['attachments_disabled']) AND !empty($function['attachments'])){
			foreach($function['attachments'] as $file){
				$path = $this->Parser->parse($file['path']);
				
				if(!empty($path)){
					if(is_array($path)){
						$path = array_filter($path);
						foreach($path as $fitem){
							$mailer->attachments($fitem);
							$this->debug[$function['name']]['files'][] = $fitem;
						}
					}else{
						$mailer->attachments($path);
						$this->debug[$function['name']]['files'][] = $path;
					}
				}
			}
		}
		
		$function['from_name'] = !empty($function['from_name']) ? $function['from_name'] : $this->get('cf_settings.email.from_name');
		$function['from_email'] = !empty($function['from_email']) ? $function['from_email'] : $this->get('cf_settings.email.from_email');

		if(!empty($function['from_name']) OR !empty($function['from_email'])){
			$from_name = $this->Parser->parsev($function['from_name']);
			$from_email = $this->Parser->parsev($function['from_email']);
			
			$mailer->from($from_email, $from_name);
			
			$this->debug[$function['name']]['from_name'] = $from_name;
			$this->debug[$function['name']]['from_email'] = $from_email;
		}
		
		if(!empty($function['reply_name']) OR !empty($function['reply_email'])){
			$reply_name = $this->Parser->parsev($function['reply_name'] ?? $function['reply_email'], 'email_params');
			$reply_email = $this->Parser->parsev($function['reply_email'], 'email_params');
			
			$mailer->replyTo($reply_email, $reply_name);
			
			$this->debug[$function['name']]['reply_name'] = $reply_name;
			$this->debug[$function['name']]['reply_email'] = $reply_email;
		}
		
		if(!empty($function['cc'])){
			$cc_addresses = $function['cc'];
			$cc_recipients = [];
			
			foreach($cc_addresses as $cc_address){
				$list = $this->Parser->parse(trim($cc_address));
				
				if(is_array($list)){
					$cc_recipients = array_merge($cc_recipients, $list);
				}else{
					$cc_recipients[] = $list;
				}
			}

			$cc_recipients = array_filter($cc_recipients);
			
			if(!empty($cc_recipients)){
				$mailer->cc($cc_recipients);
			}
			
			$this->debug[$function['name']]['cc'] = $cc_recipients;
		}
		
		if(!empty($function['bcc'])){
			$bcc_addresses = $function['bcc'];
			$bcc_recipients = [];
			
			foreach($bcc_addresses as $bcc_address){
				$list = $this->Parser->parse(trim($bcc_address));
				
				if(is_array($list)){
					$bcc_recipients = array_merge($bcc_recipients, $list);
				}else{
					$bcc_recipients[] = $list;
				}
			}

			$bcc_recipients = array_filter($bcc_recipients);
			
			if(!empty($bcc_recipients)){
				$mailer->bcc($bcc_recipients);
			}
			
			$this->debug[$function['name']]['bcc'] = $bcc_recipients;
		}

		$function = $this->controller->Behaviors->apply('before_email', $function, ['_local' => true]);
		
		$_result = $mailer->to($recipients)
		->subject($subject)
		->body($body)
		->send();
	}else{
		if(empty($function['recipients'])){
			$this->debug[$function['name']]['errors'][] = rl3('Recipients list is empty');
		}
		if(empty($function['subject'])){
			$this->debug[$function['name']]['errors'][] = rl3('Subject is empty');
		}
		if(empty($function['body']) AND empty($function['autoemail'])){
			$this->debug[$function['name']]['errors'][] = rl3('Body is empty and Auto template is disabled');
		}
	}
	
	$this->set($function['name'], $_result);
	
	if(!empty($_result)){
		$this->debug[$function['name']]['result'] = rl3('the Mail sent successfully.');
	}else{
		$this->debug[$function['name']]['result'] = rl3('the Mail could not be sent.');
	}