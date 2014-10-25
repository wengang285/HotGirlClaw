<?php

/**
 * 产生model
 */
class ModelUtil {

	
	private static $mDouBanModel;
	
	private static $mProxyModel;
	
	
	
	public static function GetProxyModel(){
		if(!isset(self::$mProxyModel)){
			self::$mProxyModel = new ProxyModel();
		}
		return self::$mProxyModel;
	}
	
	
	public static function GetDouBanModel(){
		
		if(!isset(self::$mDouBanModel)){
			self::$mDouBanModel = new DouBanModel();
		}
		return self::$mDouBanModel;
	}
	

}

?>
