<?php

namespace Jeremeamia\S3Demo\Controllers;

use GuzzleHttp\Psr7\UploadedFile;
use Jeremeamia\S3Demo\Alerts;
use Jeremeamia\S3Demo\Controller;
use Psr\Http\Message\ResponseInterface;

class Example2 extends Controller
{
    use CanMapPrefix;

    public function handleRequest(): ResponseInterface
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->view('example2', [
                'action' => '/example2',
                'subtitle' => 'PSR-7 + AWS SDK',
            ]);
        }

        $data = $this->request->getParsedBody();
        /** @var UploadedFile $file */
        $file = $this->request->getUploadedFiles()['file'] ?? null;

        if (!isset($data['fileTitle'], $data['fileCategory'], $file)) {
            return $this->alert(Alerts::ERROR, 'Invalid file upload.')->redirect('/');
        }

        $prefix = $this->mapCategoryToPrefix($data['fileCategory']);
        $this->container->getS3Client()->putObject([
            'Bucket' => $this->container->getS3Bucket(),
            'Key' => "{$prefix}/{$data['fileTitle']}",
            'Body' => $file->getStream(),
            'ACL' => 'public-read',
        ]);

        return $this->alert(Alerts::SUCCESS, "Uploaded {$data['fileTitle']} to category {$data['fileCategory']}.")
            ->redirect('/');
    }
}
