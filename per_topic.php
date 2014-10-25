
<?php

//处理单个帖子




require_once "entry.php";

$topicUrl = $argv[1];

$proxyIP = $argv[2];

$proxyPORT = $argv[3];



	
echo "topicUrl=".$topicUrl."\n";

echo "IP=".$proxyIP."\n";

echo "PORT=".$proxyPORT."\n";


$model = ModelUtil::GetDouBanModel();

$config = FileUtil::GetGlobalConfig();


$imgList = $model->GetPhotoByTopic($topicUrl,$proxyIP,$proxyPORT);


foreach($imgList as $imgUrl){
	
	$cmd = $config['FRAMEWORK_DEFAULT']['PHP_PATH']." ".WEB_ROOT."/download.php ".$imgUrl." ".$proxyIP." ".$proxyPORT."  >/dev/null  &";
	exec($cmd);
	
}


?>
