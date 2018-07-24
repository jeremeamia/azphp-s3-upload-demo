<?php

use Jeremeamia\S3Demo\App;
use Jeremeamia\S3Demo\Controllers;

require __DIR__ . '/../vendor/autoload.php';

(new App)
    ->route('GET', '/', Controllers\Home::class)
    ->route('GET', '/create-bucket', Controllers\CreateBucket::class)
    ->route('GET', '/list-objects', Controllers\ListObjects::class)
    ->route('GET', '/example1', Controllers\UploadProxyPlain::class)
    ->route('POST', '/example1', Controllers\UploadProxyPlain::class)
    ->route('GET', '/example2', Controllers\UploadProxyPsr7::class)
    ->route('POST', '/example2', Controllers\UploadProxyPsr7::class)
    ->route('GET', '/delete-object', Controllers\DeleteObject::class)
    ->run();
