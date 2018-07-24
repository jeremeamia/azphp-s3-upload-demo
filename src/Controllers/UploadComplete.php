<?php

namespace Jeremeamia\S3Demo\Controllers;

use Psr\Http\Message\ResponseInterface;

class UploadComplete extends HandleUpload
{
    public function handleRequest(): ResponseInterface
    {
        $query = $this->request->getQueryParams();
        if (!isset($query['key'])) {
            throw new \RuntimeException('The "key" was missing form the S3 upload notification.');
        }

        [$_, $category, $title] = explode('/', $query['key']);
        $this->addAlert('success', 'Success', "Uploaded {$title} to category {$category}.");

        return $this->redirect('/');
    }
}
