<?php

namespace Jeremeamia\S3Demo\Controllers;

use Aws\S3\Exception\S3Exception;
use Jeremeamia\S3Demo\Controller;
use Psr\Http\Message\ResponseInterface;

class CreateBucket extends Controller
{
    public function handleRequest(): ResponseInterface
    {
        $bucket = $this->container->getS3Bucket();

        try {
            $this->container->getS3Client()->createBucket([
                'Bucket' => $bucket,
            ]);
            $this->alert('success', "The {$bucket} bucket was created.");
        } catch (S3Exception $err) {
            if ($err->getStatusCode() === 409) {
                $this->alert('warning', "The {$bucket} bucket has already been created.");
            } else {
                $this->alert('error', "The {$bucket} bucket could not be created. {$err->getMessage()}");
            }
        }

        return $this->redirect('/');
    }
}
