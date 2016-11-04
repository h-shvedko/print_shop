<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Print-Shop',
	'language' => 'ru',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.modules.*',
		'application.components.*',
		'application.extensions.*',
	),
	'aliases' => array(
		'xupload' => 'ext.xupload'
	),

	'modules'=>array(
		'admin' => array(
			'modules'=>array(
				'catalog',
				'store',
				'price',
				'pages',
				'user',
						),
			),
		'store',
		'page',
		'message',
		'register',
		'office',
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1'),
		),
		
	),

	// application components
	'components'=>array(
		'authManager'=>array(
		   'class'=>'CDbAuthManager',
		   'connectionID'=>'db',
		   'defaultRoles' => array('guest')
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => FALSE,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
/*		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		*/
		'db'=>array(
			'connectionString' => 'mysql:host=malahova.mysql.ukraine.com.ua;dbname=malahova_db',
			'emulatePrepare' => true,
			'username' => 'malahova_db',
			'password' => '4gc2ku59',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'widgetFactory' => array(
			'widgets' => array(
				'CLinkPager' => array(
					'header' => '',
					'nextPageLabel'=>'>',
					'prevPageLabel'=>'<',
					'lastPageLabel'=>'>>',
					'firstPageLabel'=>'<<',
					'selectedPageCssClass' => 'active',
					'hiddenPageCssClass' => 'disabled',
					'htmlOptions' => array(
						'class' => 'pagination',
					 ),
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'office@print-shop.com.ua',
		'host' => 'mail.ukraine.com.ua',
		'username' => 'office@print-shop.com.ua',
		'password' => '1a2b3c4d',
		'port' => '465',
		'encryption'=>'ssl',
		'smtpauth' => true,
	),
	'import' => array(
		'application.modules.admin.modules.user.models.*',
		'application.modules.admin.modules.catalog.models.*',
		'application.modules.admin.modules.store.models.*',
		'application.modules.message.models.*',
		'application.modules.store.models.*',
		'application.components.*',
	),
);