<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
ini_set("date_default_timezone_set","PRC");
ini_set("memory_limit","1000M");
/*ini_set("SMTP","smtp.qq.com" ); 
ini_set('sendmail_from', '513245459@qq.com'); 
ini_set('port', 587);*/
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
  