# azPHP S3 Upload Demo

This is a demo project to show how to upload files to S3 via PHP.

## Installation

1. Make sure you have `docker`, `docker-compose`, and `ngrok` installed.
2. Checkout the repo and run `composer install`.
3. Copy `env.dist` to `.env` and put your credentials and bucket in it.
4. Run `ngrok http 9999`. Copy the ngrok URL for the app into `APP_HOST` in `.env`.
5. Run `docker-compose up`.
6. Go to http://localhost:9999 in browser, or the ngrok URL.
