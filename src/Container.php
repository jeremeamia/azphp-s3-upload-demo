<?php

namespace Jeremeamia\S3Demo;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;

class Container
{
    /**
     * Creates an S3 client.
     *
     * Assumes that the credentials are in the AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY environment vars.
     *
     * @return S3Client
     */
    public function getS3Client(): S3Client
    {
        return new S3Client([
            'version' => 'latest',
            'region' => $this->getAwsRegion(),
        ]);
    }

    public function getS3Bucket(): string
    {
        $bucket = getenv('S3_BUCKET_NAME');
        if (!$bucket) {
            throw new \RuntimeException('Missing config value for S3_BUCKET_NAME.');
        }

        return $bucket;
    }

    public function getAwsRegion(): string
    {
        $region = getenv('AWS_REGION');
        if (!$region) {
            throw new \RuntimeException('Missing config value for AWS_REGION.');
        }

        return $region;
    }

    public function getFlysystem(): Filesystem
    {
        $adapter = new AwsS3Adapter($this->getS3Client(), $this->getS3Bucket());

        return new Filesystem($adapter, ['visibility' => 'public']);
    }
}
