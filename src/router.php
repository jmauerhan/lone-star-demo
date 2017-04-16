<?php

require_once __DIR__ . '/../vendor/autoload.php';


use Symfony\Component\HttpFoundation\Request AS SilexRequest;
use Symfony\Component\HttpFoundation\Response AS SilexResponse;

$app = new Silex\Application();
$app['debug'] = true;
$app['debug.mode'] = 'dev';

$app->get('/', function () use ($app) {
    return $app->json([]);
});

$app->post('chirp', function (SilexRequest $silexRequest) use ($app) {
    return $app->json([]);
});

$app->run();