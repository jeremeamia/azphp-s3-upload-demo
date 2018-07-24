<?php

namespace Jeremeamia\S3Demo\Controllers;

use GuzzleHttp\Psr7\UploadedFile;
use Psr\Http\Message\ResponseInterface;

class UploadProxyPsr7 extends HandleUpload
{
    public function handleRequest(): ResponseInterface
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->html($this->renderTemplate('example2', [
                'action' => '/example2'
            ]));
        }

        $data = $this->request->getParsedBody();
        /** @var UploadedFile $file */
        $file = $this->request->getUploadedFiles()['fileUpload'] ?? null;

        if (!isset($data['fileName'], $data['fileCategory'], $file)) {
            $this->addAlert('danger', 'Error', 'Invalid file upload.');
            return $this->redirect('/');
        }

        $prefix = $this->getPrefix($_POST['fileCategory']);
        $this->container->getS3Client()->putObject([
            'Bucket' => $this->container->getS3Bucket(),
            'Key' => "{$prefix}/{$data['fileName']}",
            'Body' => $file->getStream(),
            'ACL' => 'public-read',
        ]);

        $this->addAlert('success', 'Success', "Uploaded {$data['fileName']} to category {$data['fileCategory']}.");

        return $this->redirect('/');
    }
}
