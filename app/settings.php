<?php
return [
    'settings' => [
        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/log/app.log',
            'level' => \Monolog\Logger::WARNING,
        ],
        'doctrine' => [
            'meta' => [
                'entity_path' => [
                    'app/src/Entity'
                ],
                'auto_generate_proxies' => true,
                'proxy_dir' => __DIR__ . '/cache/proxies',
                'cache' => null,
            ],
            'connection' => [
                'driver'   => 'pdo_mysql',
                'host'     => '127.0.0.1',
                'dbname'   => (getenv('UNIT_TEST_MODE') || !empty($unitTestMode)) ? 'dbxyz_test' : 'dbxyz',
                'user'     => 'root',
                'password' => '123',
            ]
        ]
    ],
];
