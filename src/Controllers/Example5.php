<?php

namespace Jeremeamia\S3Demo\Controllers;

use Aws\S3\PostObjectV4;
use Jeremeamia\S3Demo\Alerts;
use Jeremeamia\S3Demo\Controller;
use Psr\Http\Message\ResponseInterface;

use function GuzzleHttp\Psr7\uri_for;

class Example5 extends Controller
{
    use CanMapPrefix;

    public function handleRequest(): ResponseInterface
    {
        if ($this->request->getMethod() !== 'POST') {
            return $this->view('example5', [
                'action' => '/example5',
                'subtitle' => 'Just-in-time S3 PostObject',
            ]);
        }

        $data = $this->request->getParsedBody();

        if (!isset($data['fileTitle'], $data['fileCategory'], $data['fileType'], $data['fileSize'])) {
            return $this->alert(Alerts::ERROR, 'Invalid file upload data.')->error();
        }

        $prefix = $this->mapCategoryToPrefix($data['fileCategory']);
        $s3Post = $this->buildS3Post("{$prefix}/{$data['fileTitle']}", $data['fileType'], $data['fileSize']);

        return $this->json([
            'form' => [
                'attributes' => $s3Post->getFormAttributes(),
                'inputs' => $s3Post->getFormInputs(),
            ],
        ]);
    }

    /**
     * @param string $key
     * @param string $type
     * @param int $size
     * @return PostObjectV4
     * @link https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/s3-presigned-post.html
     */
    private function buildS3Post(string $key, string $type, int $size): PostObjectV4
    {
        $bucket = $this->container->getS3Bucket();
        $successActionRedirect = (string) uri_for($this->container->getAppHost())->withPath('upload-complete');

        $fields = [
            'acl' => 'public-read',
            'success_action_redirect' => $successActionRedirect,
            'key' => $key,
            'content-type' => $type,
        ];

        $policy = [
            ['acl' => 'public-read'],
            ['bucket' => $bucket],
            ['eq', '$success_action_redirect', $successActionRedirect],
            ['eq', '$key', $key],
            ['eq', '$content-type', $type],
            ['content-length-range', $size, $size],
        ];

        return new PostObjectV4($this->container->getS3Client(), $bucket, $fields, $policy, '+5 seconds');
    }
}
