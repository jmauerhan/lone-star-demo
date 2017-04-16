<?php
/**
 * Created by PhpStorm.
 * User: jessi
 * Date: 4/16/2017
 * Time: 4:56 PM
 */

namespace Chirper\Chirp;


use Chirper\Http\Response;

class UnableToCreateChirpResponse extends Response
{
    public function __construct(string $error)
    {
        $message = 'Unable to create Chirp: ' . $error;
        parent::__construct(Response::BAD_REQUEST, [], $message);
    }
}