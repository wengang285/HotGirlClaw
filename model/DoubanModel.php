<?php

/**
 * 豆瓣害羞组model
 */
class DouBanModel extends BaseModel {

	private $mGroupUrl;
	
	private $mTopicUrl;
	
	private $mPhotoUrlList;
	
	private $mStart=0;
	
	private $mPageSize=25;
	
	private $mCurrentPageIndex = 1;
	
	private $mPageCount=0;
	
	private $mConfig;
	
	
	

    function __construct() {
		
		$this->mConfig = FileUtil::GetGlobalConfig();
		
		$this->mGroupUrl=$this->mConfig['FRAMEWORK_DEFAULT']['DOUBAN_SHINE_GROUP_URL'].$mStart;
		parent::__construct();
		
    }
	
	
	public function GetPageCount(){
		return $this->mPageCount;
	}
	
	
	public function GetCurrentPage(){
		return $this->mCurrentPageIndex;
	}
	
	
	
	
	//得到害羞小组的所有话题
	
	public function GetTopicList($pageIndex,$ip,$port){
		
		$this->mCurrentPageIndex = $pageIndex;
		
		$this->mGroupUrl=$this->mConfig['FRAMEWORK_DEFAULT']['DOUBAN_SHINE_GROUP_URL'].(($pageIndex-1)*$this->mPageSize);
		
		
		echo $this->mGroupUrl."\n";
		
		$data = $this->HttpRequestByProxy($this->mGroupUrl,$ip,$port);
		
		//echo $data."\n";
		$this->mHtmlDom = new simple_html_dom();
		
		//var_dump($this->mHtmlDom);
		
		$contentDom = $this->mHtmlDom->load($data);
		
		//找到当前列表table
		$topicTable = $contentDom->find('table[class=olt]',0);
		
		//没有加载到，可能是网络不通，或者ip被封
		if(!isset($topicTable)){
			
			//更换代理，重新尝试加载
			$proxyModel = ModelUtil::GetProxyModel();
			
			$proxyModel->GetRandomProxy($proxyIP,$proxyPORT);
			
			$data = $this->HttpRequestByProxy($this->mGroupUrl,$proxyIP,$proxyPORT);
			
			$contentDom = $this->mHtmlDom->load($data);
		
			//找到当前列表table
			$topicTable = $contentDom->find('table[class=olt]',0);
			
			//还是为空，则返回失败
			if(!isset($topicTable)){
			
				echo $this->mGroupUrl." is forbidden\n";
				return array();
			}
		
		}
		
		
		
		
		//echo "topicTable=".$topicTable->innertext."\n\n\n";
		
		$topicTrs = $topicTable->find("tr");
		
		
		$topicList = array();
		
		
		
		$i=0;
		foreach($topicTrs as $tr){
			//echo "tr=".$tr->innertext."\n";
			if($i++<2){
				continue;
			}
			$fisrtTd = $tr->find("td",0);
			
			if(isset($fisrtTd)){
				$topicUrl = $fisrtTd->find("a",0)->href."";
				$topicList[]=$topicUrl;
			}
			

			
		}
		
		//$this->mHtmlDom->clear();
		
		//初始化页数
		if($this->mPageCount==0){
			
			$pageDiv = $contentDom->find("div[class=paginator]",0);
			
			$pageA = $pageDiv->find("a");
			
			$this->mPageCount=$pageDiv->find("a",count($pageA)-2)->innertext;
			
		}
		
		
		$this->mHtmlDom->clear();
		
		return $topicList;
	}
	
	//根据帖子来获得所有的图片
	
	public function GetPhotoByTopic($topicUrl,$ip,$port){
		
		$data = $this->HttpRequestByProxy($topicUrl,$ip,$port);

		$this->mHtmlDom = new simple_html_dom();
		
		$contentDom = $this->mHtmlDom->load($data);
		
		$linkReport = $contentDom->find("div[id=link-report]",0);
		
		//没有加载到，可能是网络不通，或者ip被封
		if(!isset($linkReport)){
			
			//更换代理，重新尝试加载
			$proxyModel = ModelUtil::GetProxyModel();
			
			$proxyModel->GetRandomProxy($proxyIP,$proxyPORT);
			
			$data = $this->HttpRequestByProxy($topicUrl,$proxyIP,$proxyPORT);
			
			$contentDom = $this->mHtmlDom->load($data);
		
			
			$linkReport = $contentDom->find("div[id=link-report]",0);
			
			//还是为空，则返回失败
			if(!isset($linkReport)){
			
				echo $topicUrl." is forbidden\n";
				return array();
			}
		
		}
		
		$imgDoms=array();
		if(isset($linkReport)){
			$imgDoms=$linkReport->find("img");
		}
		
		
		$photoList = array();
		
		foreach($imgDoms as $imgDom){
			$imgUrl = $imgDom->src;
			
			$photoList[]=$imgUrl;
		}
		
		$this->mHtmlDom->clear();
		
		return $photoList;
		
	}
	
	
    

}

?>
