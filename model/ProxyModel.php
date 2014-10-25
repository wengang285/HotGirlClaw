<?php

/**
 * cn-proxy 代理model
 */
class ProxyModel extends BaseModel {
	
	
	
	private $mProxyFilePath;
	
	private $mProxyArray;
	
	private $mConfig;

    function __construct() {
		
		parent::__construct();
		
		$this->mConfig = FileUtil::GetGlobalConfig();
		
		$this->mProxyFilePath=WEB_ROOT."/lib/common/Proxy.php";
		
		$data = $this->HttpRequest($this->mConfig['FRAMEWORK_DEFAULT']['PROXY_URL']);
		
		//echo $data."\n";
		$this->mHtmlDom = new simple_html_dom();
		
		//var_dump($this->mHtmlDom);
		
		$contentDom = $this->mHtmlDom->load($data);
		
		$proxyTableTrs = $contentDom->find('table[class=sortable]');
		
		
		$this->mProxyArray = array();
		
		foreach($proxyTableTrs as $proxyTable){
			
			$trs = $proxyTable->find("tr");
			
			$i=0;
			foreach($trs as $tr){
				//前两个tr不能用
				if($i++<2){
					continue;
				}
				
				$proxyIP = $tr->find("td",0)->innertext;
				$proxyPORT = $tr->find("td",1)->innertext;
				
				$tmp["IP"]=$proxyIP;
				$tmp["PORT"]=$proxyPORT;
				$this->mProxyArray[]=$tmp;
			}
			
		}
		
		$this->mHtmlDom->clear();
		
		$data = $this->HttpRequest($this->mConfig['FRAMEWORK_DEFAULT']['XC_PROXY_URL']);
		
		
		$contentDom = $this->mHtmlDom->load($data);
		
		$proxyTableTrs = $contentDom->find('table[id=ip_list]');
		
		
		foreach($proxyTableTrs as $proxyTable){
			
			$trs = $proxyTable->find("tr[class=odd]");
			

			foreach($trs as $tr){
				
				$proxyIP = $tr->find("td",1)->innertext;
				$proxyPORT = $tr->find("td",2)->innertext;
				
				$tmp["IP"]=$proxyIP;
				$tmp["PORT"]=$proxyPORT;
				$this->mProxyArray[]=$tmp;
			}
			
		}
		
		//var_dump($proxyArray);
		
		FileUtil::SaveFile($this->mProxyArray,$this->mProxyFilePath);
		
    }
	
	
	
	
	public function GetProxyArray(){
		
		return require_once $this->mProxyFilePath;
	}
	
	//随机得到一组代理IP和port
	
	public function GetRandomProxy(&$proxyIP,&$proxyPORT){
		
		
		
		$size = count($this->mProxyArray);
		
		$index = rand(0,$size-1);
		
		$proxyIP = $this->mProxyArray[$index]["IP"];
		
		$proxyPORT = $this->mProxyArray[$index]["PORT"];
		
		
	}
	
	
	
	
	
    

}

?>
