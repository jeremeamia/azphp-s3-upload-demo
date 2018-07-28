<?php

use Jeremeamia\S3Demo\App;
use Jeremeamia\S3Demo\Controllers;

require __DIR__ . '/../vendor/autoload.php';

(new App)
    ->route('GET',  '/',                Controllers\Home::class)
    ->route('GET',  '/example1',        Controllers\Example1::class)
    ->route('POST', '/example1',        Controllers\Example1::class)
    ->route('GET',  '/example2',        Controllers\Example2::class)
    ->route('POST', '/example2',        Controllers\Example2::class)
    ->route('GET',  '/example3',        Controllers\Example3::class)
    ->route('POST', '/example3',        Controllers\Example3::class)
    ->route('GET',  '/example4',        Controllers\Example4::class)
    ->route('GET',  '/example5',        Controllers\Example5::class)
    ->route('POST', '/example5',        Controllers\Example5::class)
    ->route('GET',  '/upload-complete', Controllers\UploadComplete::class)
    ->route('GET',  '/create-bucket',   Controllers\CreateBucket::class)
    ->route('GET',  '/list-objects',    Controllers\ListObjects::class)
    ->route('GET',  '/delete-object',   Controllers\DeleteObject::class)
    ->run();
