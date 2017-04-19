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

$app->get('/', function () use ($app, $chirpIoService) {
    return $app['twig']->render('index.twig');
});

$app->post('chirp', function (SilexRequest $silexRequest) use ($app, $chirpIoService) {

});

$app->run();