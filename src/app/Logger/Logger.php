<?php

declare(strict_types=1);

namespace App\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class Logger extends AbstractLogger implements LoggerInterface
{
    /**
     * @param resource $stream
     */
    private $stream;

    public function __construct(string $file)
    {
        $this->stream = fopen($file, 'a');
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $time = date('Y-m-d H:i:s');
        $content = "[$time] " . strtoupper((string)$level) . ": " . $message . PHP_EOL;

        fwrite($this->stream, $content);
    }

    public function __destruct()
    {
        fclose($this->stream);
    }
}
