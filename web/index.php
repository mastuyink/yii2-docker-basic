<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

// $config = require __DIR__ . '/../config/web.php';
// $configCommon = require __DIR__ . '/../config/config-common.php';
$config = yii\helpers\ArrayHelper::merge(
  require __DIR__ . '/../config/web.php',
  require __DIR__ . '/../config/config-common.php'
);
(new yii\web\Application($config))->run();
// echo json_encode($config);
