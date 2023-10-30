<?php

namespace App\Cache;

use Psr\SimpleCache\CacheInterface;

class Cache implements CacheInterface
{
    public function __construct(private string $cacheDir)
    {
        if (!is_dir($cacheDir)) {
            throw new \InvalidArgumentException('Cache directory does not exist: ' . $cacheDir);
        }

        $this->cacheDir = rtrim($cacheDir, '/') . '/';
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $path = $this->cacheDir . $key;

        if (file_exists($path)) {
            $data = file_get_contents($path);
            $cachedData = unserialize($data);

            if ($this->isNotExpired($cachedData)) {
                return $cachedData['value'];
            } else {
                $this->delete($key);
            }
        }

        return $default;
    }

    public function set(string $key, mixed $value, null|int|\DateInterval $ttl = null): bool
    {
        $path = $this->cacheDir . $key;

        $cachedData = [
            'value' => $value,
            'ttl' => $this->calculateExpiration($ttl),
        ];

        $data = serialize($cachedData);

        if (file_put_contents($path, $data) !== false) {
            return true;
        }

        return false;
    }

    public function delete(string $key): bool
    {
        $path = $this->cacheDir . $key;

        if (file_exists($path) && unlink($path)) {
            return true;
        }

        return false;
    }

    public function clear(): bool
    {
        $cacheFiles = glob($this->cacheDir . '*');

        foreach ($cacheFiles as $file) {
            unlink($file);
        }

        return true;
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $values = [];

        foreach ($keys as $key) {
            $values[$key] = $this->get($key, $default);
        }

        return $values;
    }

    public function setMultiple(iterable $values, null|int|\DateInterval $ttl = null): bool
    {
        $success = true;

        foreach ($values as $key => $value) {
            if (!$this->set($key, $value, $ttl)) {
                $success = false;
            }
        }

        return $success;
    }

    public function deleteMultiple(iterable $keys): bool
    {
        $success = true;

        foreach ($keys as $key) {
            if (!$this->delete($key)) {
                $success = false;
            }
        }

        return $success;
    }

    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    private function isNotExpired(array $cachedData): bool
    {
        return !isset($cachedData['ttl']) || time() < $cachedData['ttl'];
    }

    private function calculateExpiration(?int $ttl): ?int
    {
        if ($ttl === null) {
            return null;
        }

        return time() + $ttl * 60;
    }
}
