<?php

namespace Jeremeamia\S3Demo\Controllers;

use Jeremeamia\S3Demo\Alerts;
use Jeremeamia\S3Demo\Controller;
use Psr\Http\Message\ResponseInterface;

class UploadComplete extends Controller
{
    public function handleRequest(): ResponseInterface
    {
        $query = $this->request->getQueryParams();
        if (!isset($query['key'])) {
            throw new \RuntimeException('The "key" was missing form the S3 upload notification.');
        }

        [$_, $category, $title] = explode('/', $query['key']);

        return $this->alert(Alerts::SUCCESS, "Uploaded {$title} to category {$category}.")->redirect('/');
    }
}
