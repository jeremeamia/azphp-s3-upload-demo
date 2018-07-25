<?php

namespace Jeremeamia\S3Demo;

use GuzzleHttp\Psr7\{Response, ServerRequest};
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

use function GuzzleHttp\Psr7\stream_for;

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

    /**
     * Define a route that maps an HTTP method and a path to a particular Controller class.
     *
     * @param string $method
     * @param string $path
     * @param string $controller
     * @return App
     */
    public function route(string $method, string $path, string $controller): self
    {
        $this->routes[$method][$path] = $controller;

        return $this;
    }

    public function run(ServerRequestInterface $request = null): void
    {
        // Create a default PSR-7 response.
        $response = new Response();

        try {
            // Start the session (mostly for alerts).
            session_start();

            // Get the PSR-7 request (Guzzle implements this for us).
            $request = $request ?? ServerRequest::fromGlobals();

            // Router the request to a Controller to handle the logic.
            $response = $this->getController($request, $response)->handleRequest();
        } catch (\Throwable $error) {
            // Update response with an error page content, if there is an uncaught exception.
            $view = new View('error', compact('error'));
            $response = $response
                ->withStatus(500)
                ->withHeader('Content-Type', 'text/html')
                ->withBody(stream_for($view->render()));
        } finally {
            // Close the session prior to emitting the response.
            session_write_close();
        }

        // Emit the response headers and body.
        $this->emitResponse($response);
    }

    private function getController(ServerRequestInterface $request, ResponseInterface $response): Controller
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

        return new $controller($this->container, $request, $response);
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
