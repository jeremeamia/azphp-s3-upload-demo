<?php

namespace Jeremeamia\S3Demo\Controllers;

use Aws\S3\PostObjectV4;
use Jeremeamia\S3Demo\Controller;
use Psr\Http\Message\ResponseInterface;

use function GuzzleHttp\Psr7\uri_for;

class Example4 extends Controller
{
    public function handleRequest(): ResponseInterface
    {
        $s3Post = $this->buildS3Post();

        return $this->view('example4', [
            'action' => $s3Post->getFormAttributes()['action'],
            'subtitle' => 'PSR-7 + PostObject',
            'hiddenFields' => $s3Post->getFormInputs(),
        ]);
    }

    /**
     * @return PostObjectV4
     * @link https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/s3-presigned-post.html
     */
    private function buildS3Post(): PostObjectV4
    {
        $bucket = $this->container->getS3Bucket();
        $successActionRedirect = (string) uri_for($this->container->getAppHost())->withPath('upload-complete');

        $fields = [
            'acl' => 'public-read',
            'success_action_redirect' => $successActionRedirect,
        ];

        $policy = [
            ['acl' => 'public-read'],
            ['bucket' => $bucket],
            ['eq', '$success_action_redirect', $successActionRedirect],
            ['starts-with', '$key', 'assets/'],
            ['starts-with', '$fileCategory', ''],
            ['starts-with', '$fileTitle', ''],
        ];

        return new PostObjectV4($this->container->getS3Client(), $bucket, $fields, $policy, '+5 minutes');
    }
}
