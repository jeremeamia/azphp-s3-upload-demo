<?php

use Jeremeamia\S3Demo\App;
use Jeremeamia\S3Demo\Controllers\Home as HomeController;

require __DIR__ . '/../vendor/autoload.php';

(new App)
    ->route('GET', '/', HomeController::class)
    ->run();
