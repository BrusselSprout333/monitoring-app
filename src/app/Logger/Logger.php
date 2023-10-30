<?php

declare(strict_types=1);

namespace App\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class Logger extends AbstractLogger implements LoggerInterface
{
    public function __construct(private readonly string $file)
    {
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $time = date('Y-m-d H:i:s');
        $content = "[$time] " . strtoupper((string)$level) . ": " . $message . PHP_EOL;

        file_put_contents($this->file, $content, FILE_APPEND);
    }
}
