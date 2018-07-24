<?php

namespace Jeremeamia\S3Demo\Controllers;

use Psr\Http\Message\ResponseInterface;

class UploadS3Post extends HandleUpload
{
    public function handleRequest(): ResponseInterface
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->html($this->renderTemplate('example4', [
                'action' => '/example4'
            ]));
        }

        // @TODO
        exit('Not implemented yet.');
    }
}
