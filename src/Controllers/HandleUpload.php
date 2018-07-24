<?php

namespace Jeremeamia\S3Demo\Controllers;

use Jeremeamia\S3Demo\Controller;

abstract class HandleUpload extends Controller
{
    protected function getPrefix(string $category): string
    {
        static $prefixMap = [
            'images' => 'assets/images',
            'scripts' => 'assets/scripts',
            'stylesheets' => 'assets/stylesheets',
        ];

        if (!isset($prefixMap[$category])) {
            throw new \RuntimeException('No prefix matched the provided category.');
        }

        return $prefixMap[$category];
    }
}
