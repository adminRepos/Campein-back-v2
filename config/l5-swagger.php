<?php

// config/l5-swagger.php
return [
    'defaults' => [
        'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),
        'constants' => [
            'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://localhost:8000'),
        ],
    ],

    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'API Docs',
            ],
            'routes' => [
                'api' => 'api/documentation',
                'middleware' => ['api'],
                'group_options' => [],
            ],
            'proxy' => false, 

            // DÓNDE ESCRIBIR y QUÉ ESCANEAR
            'paths' => [
                'docs' => storage_path('api-docs'),
                'docs_json' => 'api-docs.json',
                'docs_yaml' => 'api-docs.yaml',

                // Escanea tus controladores
                'annotations' => [
                    base_path('app/Http/Controllers'),
                ],

                'excludes' => [],

                'base' => env('L5_SWAGGER_BASE_PATH', null),
                'views' => base_path('resources/views/vendor/l5-swagger'),
            ],
        ],
    ],
];

