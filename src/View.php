<?php

namespace Jeremeamia\S3Demo;

class View
{
    /** @var string */
    private $template;

    /** @var array */
    private $data;

    public function __construct(string $template, array $data)
    {
        $this->template = __DIR__ . "/templates/{$template}.php";
        if (!is_readable($this->template)) {
            throw new \RuntimeException("Missing template: {$this->template}");
        }

        $this->data = $data;
    }
    
    public function render(): string
    {
        // Extract data into scope.
        extract($this->data, EXTR_OVERWRITE);

        // Include the template into a buffer to capture the rendered content.
        ob_start();
        include __DIR__ . '/templates/header.php';
        /** @noinspection PhpIncludeInspection */
        include $this->template;
        include __DIR__ . '/templates/footer.php';

        // Return the rendered content from the buffer.
        return ob_get_clean();
    }
}
