<?php

namespace Core\Controller;

use Core\App;
use Laminas\Diactoros\Response\RedirectResponse;

class Controller implements ControllerInterface
{
    static function redirect(
        string $uri,
        int $status = 302,
        array $headers = []
    ) {
        $response = new RedirectResponse($uri, $status, $headers);
        App::getApp()->getRouter()->getPublisher()->publish($response);
        die();
    }
}
