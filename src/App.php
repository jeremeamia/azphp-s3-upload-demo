<?php

namespace Jeremeamia\S3Demo;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    /** @var Container */
    private $container;

    /** @var string[][] */
    private $routes;

    public function __construct(Container $container = null)
    {
        $this->container = $container ?? new Container();
    }
    
    public function route(string $method, string $path, string $controller): self
    {
        $this->routes[$method][$path] = $controller;

        return $this;
    }

    public function run(ServerRequestInterface $request = null): void
    {
        session_start();

        try {
            $request = $request ?? ServerRequest::fromGlobals();
            $response = $this->getController($request)->handleRequest();
        } catch (\Throwable $error) {
            $response = new Response(
                $error->getCode() ?: 500,
                ['Content-Type' => 'text/html'],
                "<h1>Error</h1><p>{$error->getMessage()}</p>"
            );
        }

        session_write_close();

        $this->emitResponse($response);
    }

    private function getController(ServerRequestInterface $request): Controller
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        if (!isset($this->routes[$method][$path])) {
            throw new \RuntimeException('Page not found.', 404);
        }

        $controller = $this->routes[$method][$path];
        if (!class_exists($controller) || !is_a($controller, Controller::class, true)) {
            throw new \RuntimeException("Invalid controller: {$controller}.");
        }

        return new $controller($this->container, $request, new Response(200, ['Content-Type' => 'text/html']));
    }

    private function emitResponse(ResponseInterface $response): void
    {
        // Send headers.
        $status = $response->getStatusCode();
        $reason = $response->getReasonPhrase();
        header(sprintf('HTTP/1.1 %d %s', $status, $reason), true, $status);
        foreach ($response->getHeaders() as $name => $values) {
            $first = true;
            foreach ($values as $value) {
                header(sprintf('%s: %s', $name, $value), $first, $status);
                $first = false;
            }
        }

        // Send body.
        $body = $response->getBody();
        $body->rewind();
        echo $body->getContents();
    }
}
