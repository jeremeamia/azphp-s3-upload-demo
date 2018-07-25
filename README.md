# azPHP S3 Upload Demo

This is a demo PHP project to show how to upload files to [Amazon S3][s3] via PHP.

## Installation

1. Make sure you have php7 and [composer][] installed.
2. Make sure you have [`docker`][dkr], [`docker-compose`][dkrc], and [`ngrok`][ngrok] installed.
3. Checkout the repo, `cd` to it, and run `composer install`.
4. Copy `env.dist` to `.env` (`cp env.dist .env`) and put your AWS credentials, region, and bucket in it.
    - It is recommended to use the credentials of an IAM user that just has S3 priviliges.
5. Run `ngrok http 9999`. Copy the ngrok URL for the app into `APP_HOST` in `.env`.
6. Run `docker-compose up`.
7. Go to http://localhost:9999 in browser, or the ngrok URL.

[composer]: https://getcomposer.org/
[s3]: https://aws.amazon.com/s3/
[dkr]: https://docs.docker.com/
[dkrc]: https://docs.docker.com/compose/
[ngrok]: https://ngrok.com/
