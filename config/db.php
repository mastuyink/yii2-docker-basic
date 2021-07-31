<?php

return [
    'class'               => 'yii\db\Connection',
    'dsn'                 => 'mysql:host='.getenv('MYSQL_SERVICE_NAME').';port='.getenv('MYSQL_COMPOSE_PORT').';dbname='.getenv('MYSQL_DATABASE'),
    'username'            => getenv('MYSQL_USER'),
    'password'            => getenv('MYSQL_PASSWORD'),
    'charset'             => 'utf8mb4',
    'enableSchemaCache'   => (boolean) getenv('DB_SCHEMA_CACHE_ENABLE_NOT_DEFINED'),
    'schemaCacheDuration' => (boolean) getenv('DB_SCHEMA_CACHE_DURATION'),
    'schemaCache'         => (boolean) getenv('DB_SCHEMA_CACHE_DURATION'),
];
