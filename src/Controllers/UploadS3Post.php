<?php

namespace Jeremeamia\S3Demo\Controllers;

use Aws\S3\PostObjectV4;
use Psr\Http\Message\ResponseInterface;

class UploadS3Post extends HandleUpload
{
    public function handleRequest(): ResponseInterface
    {
        $s3Post = $this->buildS3Post();

        return $this->html($this->renderTemplate('example4', [
            'action' => $s3Post->getFormAttributes()['action'],
            'hiddenFields' => $s3Post->getFormInputs(),
        ]));
    }

    /**
     * @return PostObjectV4
     * @link https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/s3-presigned-post.html
     */
    private function buildS3Post(): PostObjectV4
    {
        $bucket = $this->container->getS3Bucket();

        $fields = [
            'acl' => 'public-read',
            'success_action_redirect' => $this->container->getAppHost() . '/upload-complete',
        ];

        $policy = [
            ['acl' => 'public-read'],
            ['bucket' => $bucket],
            ['starts-with', '$key', 'assets/'],
            ['starts-with', '$success_action_redirect', ''],
            ['starts-with', '$fileCategory', ''],
            ['starts-with', '$fileTitle', ''],
        ];

        return new PostObjectV4($this->container->getS3Client(), $bucket, $fields, $policy, '+5 minutes');
    }
}
