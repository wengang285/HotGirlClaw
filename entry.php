<?php

ini_set( 'display_errors', 'on' );
error_reporting(E_ERROR);



define('WEB_PARENT_ROOT', dirname(dirname(__FILE__)) );
define('WEB_ROOT', dirname(__FILE__) );

define( 'CONFIG_PATH', WEB_ROOT."/global.cfg" );

define( 'DOUBAN_PHOTO_PATH', WEB_ROOT."/DouBanGirl/" );



//error_reporting(E_ALL & ~E_WARNING);

require_once "lib/html/simple_html_dom.php";

require_once "lib/util/FileUtil.php";



require_once "model/BaseModel.php";

require_once "model/ProxyModel.php";

require_once "model/DoubanModel.php";

require_once "lib/util/ModelUtil.php";




?>
