<?php

namespace Jeremeamia\S3Demo\Controllers;

use Jeremeamia\S3Demo\Alerts;
use Jeremeamia\S3Demo\Controller;
use Psr\Http\Message\ResponseInterface;


class Example5 extends Controller
{
    use CanMapPrefix;

    public function handleRequest(): ResponseInterface
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->view('example5', [
                'action' => '/example5',
                'subtitle' => 'Pre-Signed PUT',
            ]);
        }

        $data = $this->request->getParsedBody();

        if (!isset($data['fileTitle'], $data['fileCategory'])) {
            return $this->alert(Alerts::ERROR, 'Invalid file upload data.')->error();
        }

        $s3 = $this->container->getS3Client();
        $prefix = $this->mapCategoryToPrefix($data['fileCategory']);
        $command = $s3->getCommand('PutObject', $params = [
            'Bucket' => $this->container->getS3Bucket(),
            'Key' => "{$prefix}/{$data['fileTitle']}",
            'ACL' => 'public-read',
        ]);

        return $this->json([
            's3put' => (string) $s3->createPresignedRequest($command, '+30 seconds')->getUri(),
        ]);
    }
}
