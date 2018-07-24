<?php

namespace Jeremeamia\S3Demo;

use Aws\S3\S3Client;

class Container
{
    /** @var S3Client Singleton S3 client. */
    private $s3Client;

    public function getS3Client(): S3Client
    {
        // Create an S3 client. Assumes credentials are in the AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY env vars.
        if (!$this->s3Client) {
            $this->s3Client = new S3Client([
                'version' => 'latest',
                'region' => $this->getAwsRegion(),
            ]);
        }

        return $this->s3Client;
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
}
