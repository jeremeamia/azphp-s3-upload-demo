<?php

namespace Jeremeamia\S3Demo;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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

    public function __construct(Container $container, ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->container = $container;
        $this->request = $request;
        $this->response = $response;
    }

    abstract public function handleRequest(): ResponseInterface;

    protected function html(string $body): ResponseInterface
    {
        return $this->response->withBody(stream_for($body));
    }

    protected function redirect(string $path, int $status = 302): ResponseInterface
    {
        return new Response($status, ['Location' => $path]);
    }

    protected function renderTemplate(string $_file, array $_data = []): string
    {
        // Get and verify template filename.
        $_file = __DIR__ . '/templates/' . $_file . '.php';
        if (!is_readable($_file)) {
            throw new \RuntimeException("Missing template: {$_file}");
        }

        // Get alerts.
        $_alerts = $this->getAlerts();

        // Extract data into scope.
        extract($_data, EXTR_OVERWRITE);

        // Include the template into a buffer to capture the rendered content.
        ob_start();
        include __DIR__ . '/templates/header.php';
        /** @noinspection PhpIncludeInspection */
        include $_file;
        include __DIR__ . '/templates/footer.php';

        // Return the rendered content from the buffer.
        return ob_get_clean();
    }

    protected function addAlert(string $type, string $title, string $message): void
    {
        $_SESSION['alerts'][] = compact('type', 'title', 'message');
    }

    private function getAlerts(): array
    {
        $alerts = [];
        if (isset($_SESSION['alerts'])) {
            $alerts = array_map(function (array $alert) {
                return (object) $alert;
            }, $_SESSION['alerts']);
            unset($_SESSION['alerts']);
        }

        return $alerts;
    }
}
