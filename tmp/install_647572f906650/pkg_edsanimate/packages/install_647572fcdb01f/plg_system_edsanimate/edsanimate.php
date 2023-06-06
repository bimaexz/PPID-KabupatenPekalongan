<?php 

/**
  *	System - Animate It!
  * Copyright (C) 2014 eLEOPARD Design Studios Pvt Ltd. All rights reserved

  * This program is free software: you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation, either version 3 of the License, or
  * (at your option) any later version.

  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.

  * You should have received a copy of the GNU General Public License
  * along with this program.  If not, see <http://www.gnu.org/licenses/>.

  * For any other query please contact us at contact[at]eleopard[dot]in
**/
?>
<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );

if (!class_exists('EDS_Mobile_Detect')):
	include_once 'assets/Mobile_Detect.php';
endif;


define('JV', (version_compare(JVERSION, '4', '<') ? (version_compare(JVERSION, '3', '<') ? 'j2' : 'j3') : 'j4'));

class plgSystemEDSAnimate extends JPlugin {
	
	const TIMEOUT_DEFAULT_SEC    = 30;
	
	function onBeforeCompileHead(){
		
		$onScrollOffset = $this->params->get('scroll_offset');
		
		$loadJQuery = $this->params->get('load_jquery','1');		
		$enableSmartPhone = $this->params->get('enable_on_phone','1');
		$enableTablet = $this->params->get('enable_on_tab','1');
		$hideOverFlowX = $this->params->get('hide_overflow_x','1');
		$hideOverFlowY = $this->params->get('hide_overflow_y','0');
		$customCSS = $this->params->get('custom_css','');
		
		
		$deviceType = $this->detectDevice();
		//$deviceType = 'tablet';//$this->detectDevice();
		
			
		$enable= ($deviceType=='phone' && intval($enableSmartPhone))
		|| ($deviceType =='tablet' && intval($enableTablet))
		|| ($deviceType =='computer');
		
		
		
		$app = JFactory::getApplication();		
		
		$document = JFactory::getDocument();
		
		if($app->isClient('site') && $enable)
		{			
			$document->addStyleSheet('plugins/editors-xtd/edsanimate/assets/animate-animo.css');		
			
			if(JV=='j2'){
				if($loadJQuery == "1"){
					JHTML::_('behavior.mootools');
					$document->addScript('plugins/editors-xtd/edsanimate/assets/jquery-1.12.0.min.js');
					$document->addScriptDeclaration('					
						jQuery.noConflict();
					');
				}
			}
			else if(JV== 'j3'){
				JHtml::_('behavior.framework');
				JHtml::_('jquery.framework');
			} else if(JV== 'j4'){
				JHtml::_('jquery.framework');
			}	
			
			$document->addScript('plugins/system/edsanimate/assets/jquery.ba-throttle-debounce.min.js');
			$document->addScript('plugins/editors-xtd/edsanimate/assets/animo.min.js');
			$document->addScript('plugins/system/edsanimate/assets/viewportchecker.js');
			$document->addScriptDeclaration('
				var edsScrollOffset = "'.$onScrollOffset.'";
				var edsHideOverflowX = "'.$hideOverFlowX.'";
				var edsHideOverflowY = "'.$hideOverFlowY.'";					
			');			
			$document->addScript('plugins/system/edsanimate/assets/edsanimate.js');
			$document->addScript('plugins/system/edsanimate/assets/edsanimate.site.js');			
				
			
		}
		
		//Adding Custom CSS for every scenario
		$document->addStyleDeclaration( $customCSS );
		
	}
	
	private function detectDevice()
	{
	 	static $deviceType = null;
	 	if(!$deviceType)
	 	{
			$detect = new EDS_Mobile_Detect;
			$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
	 	}
	 	return $deviceType;
		
	}
	
	function onAfterRoute()
	{
		if (!JFactory::getApplication()->input->getInt('eds_qp', 0))
		{
			return;
		}
		
		$url = JFactory::getApplication()->input->getString('url', '');
		
		if($url)
		{
			echo $this->getByUrl($url);
			die;
		}
		
		
	}
	
	function getByUrl($url){
		// only allow url calls from administrator
		if (!JFactory::getApplication()->isClient('administrator'))
		{
			die;
		}

		// only allow when logged in
		$user = JFactory::getUser();
		if (!$user->id)
		{
			die;
		}

		if (substr($url, 0, 4) != 'http')
		{
			$url = 'http://' . $url;
		}
		
		// only allow url calls to downloads.eleopard.in domain
		if (!(preg_match('#^https?://([^/]+\.)?www\.downloads\.eleopard\.in/#', $url)))
		{
			die;
		}

		// only allow url calls to certain files
		if (strpos($url, 'www.downloads.eleopard.in/extensions/update.php') === false)
		{
			die;
		}
		
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-type: text/xml");
		
		return $this->_executeRequest('GET',$url);
	}
	
	protected function _executeRequest( $method, $url, $request_body = false, $curl_params = array() ) {

    $user_agent          = "Eleopard";
    $default_curl_params = array(
        CURLOPT_HTTPHEADER      => array('Content-Type: text/xml'),
        CURLOPT_TIMEOUT         => self::TIMEOUT_DEFAULT_SEC,
        CURLOPT_USERAGENT       => $user_agent,
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_BINARYTRANSFER  => true,
        CURLOPT_HEADER          => true,
        CURLOPT_SSL_VERIFYPEER  => false
    );

    // Replace recursive will knock this *into* an array afterwards
    if ( !empty( $curl_params[ CURLOPT_HTTPHEADER ] ) )
      unset( $default_curl_params[ CURLOPT_HTTPHEADER ] );


    $curl_params = array_replace_recursive( $default_curl_params, $curl_params );
    $method      = strtoupper( $method );

    switch ( $method ) {

      case 'GET':

        $curl_params[ CURLOPT_HTTPGET ] = true;
        $curl_params[ CURLOPT_POST ]    = false;
        break;

      case 'POST':

        $curl_params[ CURLOPT_HTTPGET ] = false;
        $curl_params[ CURLOPT_POST ]    = true;

        // IMPORTANT: Since @ is used to signify files in arrays passed to this option,
        // pre-encode this array to prevent this from attempting to read a file
        // if ( is_array( $request_body ) )
        //   $request_body = http_build_query( $request_body );

       // $curl_params[ CURLOPT_HTTPHEADER ][] = 'Content-Length: ' . strlen( $request_body );
        $curl_params[ CURLOPT_POSTFIELDS ] = $request_body;
        break;

      case 'PUT':

        $curl_params[ CURLOPT_HTTPGET ]       = false;
        $curl_params[ CURLOPT_POST ]          = false;
        $curl_params[ CURLOPT_CUSTOMREQUEST ] = 'PUT';

        // IMPORTANT: Since @ is used to signify files in arrays passed to this option,
        // pre-encode this array to prevent this from attempting to read a file
        if ( is_array( $request_body ) )
          $request_body = http_build_query( $request_body );

        $curl_params[ CURLOPT_HTTPHEADER ][] = 'Content-Length: ' . strlen( $request_body );
        $curl_params[ CURLOPT_POSTFIELDS ]   = $request_body;
        break;


      case 'DELETE':

        $curl_params[ CURLOPT_HTTPGET ]       = false;
        $curl_params[ CURLOPT_CUSTOMREQUEST ] = 'DELETE';

        // IMPORTANT: Since @ is used to signify files in arrays passed to this option,
        // pre-encode this array to prevent this from attempting to read a file
        if ( is_array( $request_body ) )
          $request_body = http_build_query( $request_body );

        $curl_params[ CURLOPT_POSTFIELDS ] = $request_body;
        break;

      default:
        throw new Exception( "Unhandled method: [{$method}]" );

    } // switch method

    $ch = curl_init( $url );

    curl_setopt_array( $ch, $curl_params );

    ////////// MAKE THE REQUEST /////////
    $request_response = curl_exec( $ch );
    /////////////////////////////////////


    $request_info  = curl_getinfo( $ch );
    $response_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    $curl_code     = curl_errno( $ch );
    $error_message = curl_error( $ch ); // Maintain if necessary, since the connection is closed


    curl_close( $ch );

    $header        = substr( $request_response, 0, $request_info['header_size'] );

    $response_body = false;


    if ( $request_info['download_content_length'] <= 0 ) {

      $exploded = explode( "\r\n\r\n", $request_response );

      while ( $exploded[0] == 'HTTP/1.1 100 Continue' )
        array_shift( $exploded );


      $response_body = ( isset( $exploded[1] ) )
                       ? $exploded[1]
                       : '';

    } // if download_content_length = 0

    else {

      $response_body = substr( $request_response, -$request_info['download_content_length'] );

    } // else


    // Unless array_shift completely solves headers in body problem, leave this line in
    if ( substr( $response_body, 0, 4 ) == 'HTTP' )
      throw new Exception( "Malformed response_body: " . var_export( $response_body, 1 ) );


    // @throws Exception on response non-2xx (success) responses from service
    if ( (int)round( $response_code, -2 ) !== 200 )
      throw new Exception( "Unsuccessful Request, response ({$response_code}): " . ( empty( $response_body ) ? '' : ": {$response_body} " ) );


    return $response_body;


  } // _executeRequest
	
}
