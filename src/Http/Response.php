<?php
namespace Chirper\Http;

use GuzzleHttp\Psr7\Response AS Psr7Response;

class Response extends Psr7Response
{
    const OK = 200;
    const CREATED = 201;
    const BAD_REQUEST = 400;
    const INTERNAL_SERVER_ERROR = 500;
}