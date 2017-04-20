<?php

require_once __DIR__ . '/../vendor/autoload.php';


use Symfony\Component\HttpFoundation\Request AS SilexRequest;
use Symfony\Component\HttpFoundation\Response AS SilexResponse;

$app               = new Silex\Application();
$app['debug']      = true;
$app['debug.mode'] = 'dev';

$dsn    = 'pgsql:dbname=chirper;host=chirper-db';
$dbUser = 'postgres';
$dbPass = 'postgres';
$pdo    = new PDO($dsn, $dbUser, $dbPass);

$transformer       = new \Chirper\Chirp\JsonApiChirpTransformer();
$persistenceDriver = new \Chirper\Chirp\PdoPersistenceDriver($pdo);
$chirpIoService    = new \Chirper\Chirp\ChirpIoService($transformer, $persistenceDriver);

$app->get('/', function () use ($app, $chirpIoService) {
    $response = $chirpIoService->getTimeline();
    return new \Symfony\Component\HttpFoundation\Response($response->getBody()->getContents(), $response->getStatusCode());
});

$app->post('chirp', function (SilexRequest $silexRequest) use ($app, $chirpIoService) {

    $request  = new \Chirper\Http\Request('POST', 'chirp', [], $silexRequest->getContent());
    $response = $chirpIoService->create($request);

    return new \Symfony\Component\HttpFoundation\Response($response->getBody()->getContents(), $response->getStatusCode());
});

$app->run();