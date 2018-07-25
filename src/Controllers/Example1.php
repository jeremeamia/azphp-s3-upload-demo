<?php

namespace Jeremeamia\S3Demo\Controllers;

use Jeremeamia\S3Demo\Alerts;
use Jeremeamia\S3Demo\Controller;
use Psr\Http\Message\ResponseInterface;

class Example1 extends Controller
{
    use CanMapPrefix;

    public function handleRequest(): ResponseInterface
    {
        if (empty($_POST)) {
            return $this->view('example1', [
                'action' => '/example1',
                'subtitle' => 'Superglobals + AWS SDK',
            ]);
        }

        if (!isset($_POST['fileTitle'], $_POST['fileCategory'], $_FILES['file'])) {
            return $this->alert(Alerts::ERROR, 'Invalid file upload. Missing required fields.')->redirect('/');
        }

        $prefix = $this->mapCategoryToPrefix($_POST['fileCategory']);
        $this->container->getS3Client()->putObject([
            'Bucket' => $this->container->getS3Bucket(),
            'Key' => "{$prefix}/{$_POST['fileTitle']}",
            'SourceFile' => $_FILES['file']['tmp_name'],
            'ACL' => 'public-read',
        ]);

        return $this->alert(Alerts::SUCCESS, "Uploaded {$_POST['fileTitle']} to category {$_POST['fileCategory']}.")
            ->redirect('/');
    }
}
