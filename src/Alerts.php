<?php

namespace Jeremeamia\S3Demo;

class Alerts implements \IteratorAggregate
{
    const ERROR = 'error';
    const WARNING = 'warning';
    const SUCCESS = 'succces';

    private static $alertTypeMap = [
        self::ERROR   => ['type' => 'danger',  'title' => 'Error'],
        self::WARNING => ['type' => 'warning', 'title' => 'Warning'],
        self::SUCCESS => ['type' => 'success', 'title' => 'Success'],
    ];
    
    public function add(string $type, string $message): void
    {
        if (!isset($_SESSION['alerts'])) {
            $_SESSION['alerts'] = [];
        }

        if (!isset(self::$alertTypeMap[$type])) {
            throw new \RuntimeException("The alert type \"{$type}\" is invalid.");
        }

        $_SESSION['alerts'][] = self::$alertTypeMap[$type] + compact('message');
    }

    public function getIterator(): \Iterator
    {
        $alerts = [];
        if (isset($_SESSION['alerts'])) {
            $alerts = array_map(function (array $alert) {
                return (object) $alert;
            }, $_SESSION['alerts']);
            unset($_SESSION['alerts']);
        }

        return new \ArrayIterator($alerts);
    }
}
