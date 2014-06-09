<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'miucool.cn',
	'language'=>'zh_cn',
	'theme'=>'classic',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName'=>false,     // false不需要引号
            'urlSuffix'=>'.html',
            'rules'=>array(
                    ''=>'site/index',
                    '<controller:article>-<id:\d+>' => '<controller>/view',
                    '<controller:article>-<category:.+>' => '<controller>/index',

            ),
        ),
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yiiweb',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'enableProfiling'=>true, 
			'enableParamLogging'=>true,
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					//'class'=>'CFileLogRoute',
					//'levels'=>'error, warning',
					'class'=>'ext.yiidebugtoolbar.YiiDebugToolbarRoute', 
              		'ipFilters'=>array('127.0.0.1'), 
				),
				// uncomment the following to show log messages on web pages
				/*array(
					'class'=>'CWebLogRoute',
					'levels'=>'trace',
					'categories'=>'system.db.*',
				),
				array(
					'class'=>'CProfileLogRoute',
					'levels'=>'profile',
				),*/
				/*array( 
              		'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute', 
              		'ipFilters'=>array('127.0.0.1'), 
          		), */
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'513245459@qq.com',
		'max_article_new'=>15,
		'max_article_hot'=>15,
	),
);