<?php
date_default_timezone_set("Asia/Shanghai"); 
ini_set("memory_limit","1000M");
ini_set('set_time_limit',0);
ini_set('max_execution_time',0);
// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/protected/adminweb/config/main.php';
$function=dirname(__FILE__).'/protected/function.php';
$uploaddir = dirname(__FILE__).'/protected/adminweb/upload/';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
define('UPLOAD_DIR',$uploaddir);

require_once($yii);
require_once($function);
Yii::createWebApplication($config)->run();
