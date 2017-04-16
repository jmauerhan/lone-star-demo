<?php

require_once __DIR__ . '/../vendor/autoload.php';


use Symfony\Component\HttpFoundation\Request AS SilexRequest;
use Symfony\Component\HttpFoundation\Response AS SilexResponse;

$app = new Silex\Application();
$app['debug'] = true;
$app['debug.mode'] = 'dev';

$app->get('/', function () use ($app) {
    $responseData = (object)[
        'data' => [
            (object)[
                'type' => 'chirps',
                'id' => 'uuid',
                'attributes' => (object)[
                    'text' => 'Chirp Text'
                ]
            ],
            (object)[
                'type' => 'chirps',
                'id' => 'uuid-2',
                'attributes' => (object)[
                    'text' => 'Another Chirp'
                ]
            ],
        ]
    ];
    return $app->json($responseData);
});

$app->post('chirp', function (SilexRequest $silexRequest) use ($app) {
    $responseData = (object)[
        'data' => (object)[
            'type' => 'chirps',
            'id' => 'uuid',
            'attributes' => (object)[
                'text' => 'Chirp Text'
            ]
        ]
    ];
    return $app->json($responseData);
});

$app->run();