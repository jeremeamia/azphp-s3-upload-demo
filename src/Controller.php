<?php

namespace Jeremeamia\S3Demo;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

use function GuzzleHttp\Psr7\stream_for;

abstract class Controller
{
    const TEMPLATES_DIR = __DIR__ . '/templates/';

    /** @var Container  */
    protected $container;

    /** @var ServerRequestInterface */
    protected $request;

    /** @var ResponseInterface */
    protected $response;

    /** @var Alerts */
    private $alerts;

    public function __construct(Container $container, ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->container = $container;
        $this->request = $request;
        $this->response = $response;
        $this->alerts = new Alerts();
    }

    abstract public function handleRequest(): ResponseInterface;

    protected function view(string $file, array $data = []): ResponseInterface
    {
        $view = new View($file, $data + ['alerts' => $this->alerts]);

        return $this->response
            ->withHeader('Content-Type', 'text/html')
            ->withBody(stream_for($view->render()));
    }

    protected function redirect(string $path): ResponseInterface
    {
        return $this->response
            ->withHeader('Location', $path)
            ->withStatus(302);
    }

    protected function alert(string $type, string $message): self
    {
        $this->alerts->add($type, $message);

        return $this;
    }
}
