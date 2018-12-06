<?php 
/**INFORMATION**\
Created: 17-10-2012 04:40:00
Author: M.Wasiq Ghaznavi

Last Modified: 17-10-2012 04:40:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<?php
	class request {
		public static $BASE_URL;
		public static $BASE_PATH;
		public static $ABSOLUTE_PATH;
		public static $ABSOLUTE_URL;
		
		static function Get ($variable) {
			return (isset($_GET[$variable])) ? $_GET[$variable] : false;
		}
		
		static function Post ($variable) {
			return (isset($_POST[$variable])) ? $_POST[$variable] : false;
		}
		
		static function GetPost ($variable) {
			return (isset($_REQUEST[$variable])) ? $_REQUEST[$variable] : false;
		}
		
		static function File ($variable) {
            if (isset($_FILES[$variable])) {
                return $_FILES[$variable];
            }
            return false;
        }
		
		static function hasGetVariables () {
			return (bool) (count($_GET) > 0);
		}
		
		static function hasPostVariables () {
			return (bool) (count($_POST) > 0);
		}
		
		static function getGetVariables () {
            if (isset($_GET)) {
                return (object) $_GET;
            }
            return false;
		}
		
		static function getPostVariables () {
            if (isset($_POST)) {
                return (object) $_POST;
            }
            return false;
		}
		
		static function Parameters () {
			self::$ABSOLUTE_PATH = $_SERVER['DOCUMENT_ROOT'].'/';
			self::$BASE_PATH = 'http://'.$_SERVER['SERVER_NAME'].'/';
			self::$BASE_URL = 'http://'.$_SERVER['SERVER_NAME'].'/admin/';
			self::$ABSOLUTE_URL = 'http://'.$_SERVER['SERVER_NAME'].'/';
			$ignoreCase = dirname(__FILE__);
			$parameters = explode("/", $_SERVER['REQUEST_URI']);
			
			$returnObject = array();
			foreach($parameters as $parameter) {
				if($parameter != ""){
					if(!preg_match("/^\?/",$parameter)){
						$case="/\b".$parameter."\b/";
						if(preg_match($case,$ignoreCase)){
							self::$BASE_PATH .= $parameter.'/';
							self::$ABSOLUTE_PATH .= $parameter.'/';
						}
						else{
							if(preg_match("/(\D+)\?/",$parameter,$part)){
								
								$parameter = $part[1];
							}
						if($parameter != "index.php"){
							$returnObject [] = $parameter;
							}
						}
					}
				}
			}
			
			return $returnObject;
		}
		
		static function Link($request=''){
			$strLink = self::$BASE_PATH;
			
			$parameters = self::Parameters();
			foreach($parameters as $parameter){
				$strLink .= $parameter.'/';
			}
			
			if($request != ''){
				$request = explode("=",$request);
				$strLink .= (preg_match("/\?/",$strLink))?'&':'?';
				$strLink .= $request[0].'='.$request[1];
			}
			
			return $strLink;
		}
		
		static function Curl($url){
			$objCurl = curl_init();
			curl_setopt($objCurl, CURLOPT_URL, $url);
			curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($objCurl, CURLOPT_USERAGENT, 1);
			curl_setopt($objCurl, CURLOPT_FOLLOWLOCATION, true);
			$strData = curl_exec($objCurl);
			curl_close($objCurl);
			
			return $strData;
		}
		
	}
