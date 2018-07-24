<?php

namespace Jeremeamia\S3Demo\Controllers;

use Jeremeamia\S3Demo\Controller;
use Psr\Http\Message\ResponseInterface;

class DeleteObject extends Controller
{
    public function handleRequest(): ResponseInterface
    {
        $key = $this->request->getQueryParams()['key'] ?? null;
        if (!$key) {
            throw new \RuntimeException('You must provide a key in the query string to delete.');
        }

        $bucket = $this->container->getS3Bucket();
        $this->container->getS3Client()->deleteObject([
            'Bucket' => $bucket,
            'Key' => $key,
        ]);

        $this->addAlert('success', 'Success', "Deleted the object with key {$key}.");

        return $this->redirect('/');
    }
}
