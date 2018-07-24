<?php

namespace Jeremeamia\S3Demo\Controllers;

use Jeremeamia\S3Demo\Controller;
use Psr\Http\Message\ResponseInterface;

class ListObjects extends Controller
{
    public function handleRequest(): ResponseInterface
    {
        $bucket = $this->container->getS3Bucket();

        $objects = $this->container->getS3Client()
            ->getPaginator('ListObjects', [
                'Bucket' => $bucket,
            ])
            ->search('Contents[].Key');

        return $this->html($this->renderTemplate('list', compact('bucket', 'objects')));
    }
}
