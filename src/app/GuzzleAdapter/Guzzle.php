<?php

namespace App\GuzzleAdapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Guzzle implements ClientInterface
{
    public function __construct(
        protected Client $guzzle
    ) {}

    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * @throws ClientExceptionInterface if an error happens while processing the request
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->guzzle->send($request);
        } catch (BadResponseException $e) {
            return $e->getResponse();
        } catch (\Throwable $e) {
            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
