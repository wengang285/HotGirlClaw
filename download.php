
<?php

//处理单个图片下载




require_once "entry.php";

$imgUrl = $argv[1];

$proxyIP = $argv[2];

$proxyPORT = $argv[3];



	
echo "photoUrl=".$imgUrl."\n";

echo "IP=".$proxyIP."\n";

echo "PORT=".$proxyPORT."\n";


$config = FileUtil::GetGlobalConfig();



$fileName = FileUtil::GetFileName($imgUrl);

$destPath = DOUBAN_PHOTO_PATH;

if(!empty($config['FRAMEWORK_DEFAULT']['PHOTO_PATH'])){
	$destPath=$config['FRAMEWORK_DEFAULT']['PHOTO_PATH'];
}


if(!file_exists($destPath)){
	mkdir($destPath);
}


FileUtil::DownLoadFile($imgUrl,$fileName,$destPath,$proxyIP,$proxyPORT);

echo "DownLoad ".$imgUrl."\n";
			

	








//echo $imgList[0];



//var_dump($model->GetTopicList(1));

?>
