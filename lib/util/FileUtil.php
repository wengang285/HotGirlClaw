<?php

/**
 * 工具类
 */
class FileUtil {

	private static $mConfig;
	
    //下载文件
	public static function DownLoadFile($fileUrl,$fileName,$destPath,$proxyIP,$proxyPORT){
		
		if(!file_exists($destPath)){
			throw new Exception($destPath." is not exists\n");
		}
		
		if(!is_dir($destPath)){
			throw new Exception($destPath." is not dir\n");
		}
		
		$filePath = $destPath.$fileName;
		
		if(file_exists($filePath)){
			echo $filePath." is already exists\n";
			return false;
			//throw new Exception($filePath." is already exists");
		}
		
		
		if(empty($fileUrl)){
			echo "url file is not exists\n";
			return false;
			//throw new Exception("url file is not exists");
		}
		
		$ext=strrchr($fileUrl,"."); 
		if($ext!=".gif" && $ext!=".jpg" && $ext!=".png"){
			echo $fileUrl." is not photo\n";
			return false;
			//throw new Exception("file is not photo");
		}

		/*
		ob_start(); 
		readfile($fileUrl); 
		$img = ob_get_contents(); 
		ob_end_clean(); 
		$size = strlen($img); 
		*/
		
		
		
		$proxy = $proxyIP;
		
		$proxyport=$proxyPORT;
		
		$user_agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; .NET CLR 1.1.4322)";
		$curl = curl_init($fileUrl);
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl,CURLOPT_PROXY,$proxy);
		curl_setopt($curl,CURLOPT_PROXYPORT,$proxyport);
		
		curl_setopt ($curl, CURLOPT_USERAGENT, $user_agent); // 模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($curl,CURLOPT_TIMEOUT,120);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__)); 
		
		
		$img = curl_exec($curl);
		
		
		
		//下载失败，再试一次
		if($img==false){
			$img = curl_exec($curl);
			if($img==false){
				curl_close($curl);
				echo $fileUrl." is not downloaded";
				return false;
			}
			
		}
		
		curl_close($curl);
		
		$fp = @fopen($filePath, "a");
		
		fwrite($fp,$img); 
		fclose($fp); 
		
		return true;
		
	}
	
	 //得到文件名
	public static function GetFileName($fileUrl){
		if(empty($fileUrl)){
			echo "url file is not exists\n";
			//throw new Exception("url file is not exists");
		}
		
		$ext=strrchr($fileUrl,"/"); 
		
		return $ext;
	}
	
	
	//保存文件
	public static function SaveFile($arrayInfo,$filePath){
        $strArr = var_export($arrayInfo, true);
		

        $strArr = "<?php \n return ".$strArr.";\n ?>";
        
        
        if (file_put_contents($filePath, $strArr) === false) {
            return -1;
        } else {
            return 0;
        }
    }
	
	//得到上次执行到的页数
	public static function GetLastPage(){
		
		$pageFilePath=WEB_ROOT."/lib/common/Page.php";
		
		return require_once $pageFilePath;
	
	}
	
	//保存处理的页数
	public static function SavePage($pageIndex){
		
		$pageFilePath=WEB_ROOT."/lib/common/Page.php";
		
		self::SaveFile($pageIndex,$pageFilePath);
		
		
	}
	
	public static function GetGlobalConfig()
	{
		
		if(!isset(self::$mConfig)){
			self::$mConfig = parse_ini_file(CONFIG_PATH, true);
		}
		return self::$mConfig;
	}

	

}

?>
