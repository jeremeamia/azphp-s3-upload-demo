<?php

namespace Jeremeamia\S3Demo;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function GuzzleHttp\Psr7\stream_for;

abstract class Controller
{
    /** @var Container  */
    protected $container;

    /** @var ServerRequestInterface */
    protected $request;

    /** @var ResponseInterface */
    protected $response;

    public function __construct(Container $container, ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->container = $container;
        $this->request = $request;
        $this->response = $response;
    }

    abstract public function handleRequest(): ResponseInterface;

    protected function respondWith(string $body): ResponseInterface
    {
        return $this->response->withBody(stream_for($body));
    }

    protected function renderTemplate(string $_file, array $_data = []): string
    {
        // Get and verify template filename.
        $_file = __DIR__ . '/templates/' . $_file . '.php';
        if (!is_readable($_file)) {
            throw new \RuntimeException("Missing template: {$_file}");
        }

        // Extract data into scope.
        extract($_data, EXTR_OVERWRITE);

        // Include the template into a buffer to capture the rendered content.
        ob_start();
        /** @noinspection PhpIncludeInspection */
        include $_file;

        // Return the rendered content from the buffer.
        return ob_get_clean();
    }
}
