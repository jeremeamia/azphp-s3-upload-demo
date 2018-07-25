<?php

namespace Jeremeamia\S3Demo\Controllers;

use GuzzleHttp\Psr7\UploadedFile;
use Jeremeamia\S3Demo\Controller;
use Psr\Http\Message\ResponseInterface;

class Example3 extends Controller
{
    use CanMapPrefix;

    /**
     * @return ResponseInterface
     * @throws \League\Flysystem\FileExistsException
     */
    public function handleRequest(): ResponseInterface
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->view('example3', [
                'action' => '/example3',
                'subtitle' => 'PSR-7 + Flysystem',
            ]);
        }

        $data = $this->request->getParsedBody();
        /** @var UploadedFile $file */
        $file = $this->request->getUploadedFiles()['file'] ?? null;

        if (!isset($data['fileTitle'], $data['fileCategory'], $file)) {
            $this->alert('error', 'Invalid file upload.')->redirect('/');
        }

        $prefix = $this->mapCategoryToPrefix($data['fileCategory']);
        $this->container->getFlysystem()->writeStream(
            "{$prefix}/{$data['fileTitle']}",
            $file->getStream()->detach()
        );

        return $this->alert('success', "Uploaded {$data['fileTitle']} to category {$data['fileCategory']}.")->redirect('/');
    }
}
