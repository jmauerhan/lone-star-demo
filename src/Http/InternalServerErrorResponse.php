<?php
/**
 * Created by PhpStorm.
 * User: jessi
 * Date: 4/16/2017
 * Time: 5:13 PM
 */

namespace Chirper\Http;


class InternalServerErrorResponse extends Response
{
    public function __construct(string $message = null)
    {
        parent::__construct(Response::INTERNAL_SERVER_ERROR, [], 'Sorry, something has gone wrong!' . PHP_EOL . $message);
    }
}