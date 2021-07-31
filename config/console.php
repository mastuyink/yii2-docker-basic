<?php
$configCommon = require __DIR__ . '/config-common.php';
$config = [
    'id'                  => 'yii2-basic-docker-console',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'app\commands',
    'components'          => [
      'log' => [
        'targets' => [
          [
            'class'  => 'yii\log\FileTarget',
            'levels' => ['error', 'warning'],
          ],
        ],
      ],
    ],
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];
$config['aliases']['@tests'] = '@app/tests';

return $config;
