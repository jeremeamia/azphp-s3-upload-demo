<?php

namespace Jeremeamia\S3Demo\Controllers;

use Jeremeamia\S3Demo\Controller;
use Psr\Http\Message\ResponseInterface;

class Home extends Controller
{
    public function handleRequest(): ResponseInterface
    {
        return $this->html($this->renderTemplate('home', [
            'name' => getenv('HELLO_NAME') ?: 'World',
        ]));
    }
}
