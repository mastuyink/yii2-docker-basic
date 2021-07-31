<?php
$params = require __DIR__ . '/params.php';
$db     = require __DIR__ . '/db.php';
$config = [
  'components' => [
    'db'    => $db,
    'cache' => [
      'class' => 'yii\caching\FileCache',
    ],
    'mailer' => [
      'class'            => 'yii\swiftmailer\Mailer',
      'useFileTransport' => false,
      'transport'        => [
        'class'      => 'Swift_SmtpTransport',
        'encryption' => getenv('EMAIL_ENCRYPTION'),
        'host'       => getenv('EMAIL_HOST'),
        'port'       => getenv('EMAIL_PORT'),
        'username'   => getenv('EMAIL_SENDER'),
        'password'   => getenv('EMAIL_PASSWORD'),
        'authMode'   => getenv('EMAIL_AUTH_MODE'),
      ],
    ],
  ],
  'params'  => $params,
  'aliases' => [
    '@bower' => '@vendor/bower-asset',
    '@npm'   => '@vendor/npm-asset',
  ],
  'language'   => 'en-US',
];

if (YII_ENV_DEV) {
  $config['bootstrap'][]    = 'gii';
  $config['modules']['gii'] = [
    'class'      => 'yii\gii\Module',
    'allowedIPs' => explode(',',str_replace(' ','',getenv('ALLOWED_DEBUG_IP'))),
  ];
}
return $config;