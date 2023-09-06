<?php

namespace Core\Controller;

interface ControllerInterface
{
    static function redirect(
        string $uri,
        int $status = 302,
        array $headers = []
    );
}
