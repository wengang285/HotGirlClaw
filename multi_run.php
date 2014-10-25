<?php




require_once "entry.php";






$proxyModel = ModelUtil::GetProxyModel();


$proxyModel->GetRandomProxy($proxyIP,$proxyPORT);

				
echo "IP=".$proxyIP."\n";
				
echo "PORT=".$proxyPORT."\n";

$model = ModelUtil::GetDouBanModel();

$config = FileUtil::GetGlobalConfig();

$lastPage= FileUtil::GetLastPage();

try{
	
	
	
	
	$model->GetTopicList(1,$proxyIP,$proxyPORT);

	$pageCount = $model->GetPageCount();
	
	echo "pageCount=".$pageCount."\n";



	for($i=$lastPage;$i<=$pageCount;$i++){
		
		echo "Page=".$i."\n";
		
		FileUtil::SavePage($i);
		
		$proxyModel->GetRandomProxy($proxyIP,$proxyPORT);
		
		echo "IP=".$proxyIP."\n";
				
		echo "PORT=".$proxyPORT."\n";
		
		
		$topicList = $model->GetTopicList($i,$proxyIP,$proxyPORT);
		
		
		
		foreach($topicList as $topicUrl){
		
			echo "topicUrl=".$topicUrl."\n";
			
			
			$cmd = $config['FRAMEWORK_DEFAULT']['PHP_PATH']." ".WEB_ROOT."/per_topic.php ".$topicUrl." ".$proxyIP." ".$proxyPORT."  >/dev/null  &";
			exec($cmd);
			
			/*
			$proxyModel->GetRandomProxy($proxyIP,$proxyPORT);
			
			$imgList = $model->GetPhotoByTopic($topicUrl,$proxyIP,$proxyPORT);
			
			
			foreach($imgList as $imgUrl){
				
				$cmd = $config['FRAMEWORK_DEFAULT']['PHP_PATH']." ".WEB_ROOT."/download.php ".$imgUrl." ".$proxyIP." ".$proxyPORT."  >/dev/null  &";
				exec($cmd);
				
			}
			*/
			
			
			
			
			
			
			
		}
		
	}
}
catch(Exception $e){
	//记录当前的完成的页码
	echo "currentPageIndex=".$model->GetCurrentPage()."\n";

	echo $e->getMessage();
}


?>
