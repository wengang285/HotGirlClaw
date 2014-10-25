<?php

/**
 * 基础dao
 */
class BaseModel {

    public $mHtmlDom;
	

    function __construct() {
		$mHtmlDom = new simple_html_dom();
		//var_dump($mHtmlDom);
    }
    
	
	//http请求，返回html内容
	public function HttpRequest($url){
		/*模拟浏览器*/
		$user_agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; .NET CLR 1.1.4322)";
		$ch= curl_init($url);
		//$postFields = $this->createPostParams($params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent); // 模拟用户使用的浏览器
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch,CURLOPT_TIMEOUT,5);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_COOKIEJAR,dirname(__FILE__)); 
		
		$data = curl_exec($ch);
		if($data === false){
			return curl_error($ch);
		}
		curl_close($ch);
		return $data;
	}
	
	
	//http请求，返回html内容
	public function HttpRequestByProxy($url,$proxyIP,$proxyPort){
		/*模拟浏览器*/
		$user_agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; .NET CLR 1.1.4322)";
		$ch= curl_init($url);
		//$postFields = $this->createPostParams($params);
		curl_setopt($ch,CURLOPT_PROXY,$proxyIP);
		curl_setopt($ch,CURLOPT_PROXYPORT,$proxyPort);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent); // 模拟用户使用的浏览器
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch,CURLOPT_TIMEOUT,10);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_COOKIEJAR,dirname(__FILE__)); 
		
		$data = curl_exec($ch);
		if($data === false){
			return curl_error($ch);
		}
		curl_close($ch);
		return $data;
	}

	

}

?>
