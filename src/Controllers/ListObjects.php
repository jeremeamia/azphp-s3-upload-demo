<?php

namespace Jeremeamia\S3Demo\Controllers;

use Jeremeamia\S3Demo\Controller;
use Psr\Http\Message\ResponseInterface;

class ListObjects extends Controller
{
    public function handleRequest(): ResponseInterface
    {
        $region = $this->container->getAwsRegion();
        $bucket = $this->container->getS3Bucket();
        $objects = $this->container->getS3Client()
            ->getPaginator('ListObjects', [
                'Bucket' => $bucket,
            ])
            ->search('Contents[].Key');
        $getUrl = function ($key) use ($region, $bucket) {
            return "https://{$bucket}.s3-{$region}.amazonaws.com/{$key}";
        };

        return $this->view('list', compact('bucket', 'objects', 'getUrl'));
    }
}
