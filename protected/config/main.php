<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('chartjs', dirname(__FILE__).'/../extensions/yii-chartjs');
return array(
    'language' => 'zh_cn',
    'timeZone' => 'Asia/Shanghai',
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '友笑网',
    //'defaultController'=>'index',
    // preloading 'log' component
    //'preload'=>array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.query.*',
        'application.utils.*',
        'application.helpers.*',
        'application.extensions.yii-mail.YiiMailMessage',
        'application.extensions.openflashchart.EOFC2',
        'application.extensions.yii-chartjs.components.ChartJs',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'usho85121608',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'admin',
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
      
            'chartjs'=>array(
                'class'=>'application.extensions.yii-chartjs.components.ChartJs',
          
        ),
        // uncomment the following to enable URLs in path-format 
        'image' => array(
            'class' => 'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver' => 'GD',
        // ImageMagick setup path
        // 'params'=>array('directory'=>'/opt/local/bin'),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'urlSuffix' => '.html',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
        // uncomment the following to use a MySQL database
        'db' => array(
            'connectionString' =>
            'mysql:host=112.124.50.151;dbname=usho',
            'emulatePrepare' => true,
            'username' => 'usho',
            'password' => '85121608',
            'charset' => 'utf8',
        ),
        'db_' => array(
            'connectionString' =>
            'mysql:host=localhost;dbname=usho',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
        ),
        'cache' => array(
            'class' => 'system.caching.CXCache',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                array(
                    'class' => 'CWebLogRoute',
                //'levels'=>'trace',     //级别为trace
                //'categories'=>'system.db.*' //只显示关于数据库信息,包括数据库连接,数据库执行语句
                ),
            ),
        ),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'viewPath' => 'application.modules.admin.views.monthlyTemplate.uploads',
            'logging' => true,
            'dryRun' => false,
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'smtpcloud.sohu.com',
                'username' => 'postmaster@usho2.sendcloud.org',
                'password' => 'bvTdUDivSEDX7u7R',
                'port' => '25',
            //'encryption'=>'ssl',   
            ),
        ),
        'mail163' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'viewPath' => 'application.modules.admin.views.monthlyTemplate.uploads',
            'logging' => true,
            'dryRun' => false,
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'smtp.163.com',
                'username' => 'ushosales@163.com',
                'password' => 'ushosales1987',
                'port' => '25',
            //'encryption'=>'ssl',   
            ),
        ),
    ),
    'preload'=>array(
        'chartjs'
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => require(dirname(__FILE__) . '/params.php'),
//    'params' => array(
//        // this is used in contact page
//        'adminEmail' => 'webmaster@example.com',
//    ),
);
