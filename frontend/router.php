<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request AS SilexRequest;
use Symfony\Component\HttpFoundation\Response AS SilexResponse;

$app               = new Silex\Application();
$app['debug']      = true;
$app['debug.mode'] = 'dev';

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . DIRECTORY_SEPARATOR . 'views',
));

$clientOpt = ['base_uri' => 'http://chirper-api'];
$client    = new \GuzzleHttp\Client($clientOpt);

$app->get('/', function () use ($app, $client) {

    $response     = $client->get('/');
    $responseJson = $response->getBody()->getContents();
    $obj          = json_decode($responseJson);
    $data         = $obj->data;

    $chirps = [];
    foreach ($data AS $item) {
        $chirp    = new \Chirper\Chirp\Chirp($item->id, $item->attributes->text);
        $chirps[] = $chirp;
    }

    return $app['twig']->render('index.twig', ['chirps' => $chirps]);
});

$app->post('chirp', function (SilexRequest $silexRequest) use ($app, $client) {

});

$app->run();