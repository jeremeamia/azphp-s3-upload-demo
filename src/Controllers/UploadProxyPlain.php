<?php

namespace Jeremeamia\S3Demo\Controllers;

use Psr\Http\Message\ResponseInterface;

class UploadProxyPlain extends HandleUpload
{
    public function handleRequest(): ResponseInterface
    {
        if (empty($_POST)) {
            return $this->html($this->renderTemplate('example1', [
                'action' => '/example1'
            ]));
        }

        if (!isset($_POST['fileTitle'], $_POST['fileCategory'], $_FILES['file'])) {
            $this->addAlert('danger', 'Error', 'Invalid file upload.');
            return $this->redirect('/');
        }

        $prefix = $this->getPrefix($_POST['fileCategory']);
        $this->container->getS3Client()->putObject([
            'Bucket' => $this->container->getS3Bucket(),
            'Key' => "{$prefix}/{$_POST['fileTitle']}",
            'SourceFile' => $_FILES['file']['tmp_name'],
            'ACL' => 'public-read',
        ]);

        $this->addAlert('success', 'Success', "Uploaded {$_POST['fileTitle']} to category {$_POST['fileCategory']}.");

        $this->redirect('/');
    }
}
