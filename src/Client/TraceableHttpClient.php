<?php

namespace esome\TraceIdBundle\Client;

use esome\TraceIdBundle\Services\TraceIdProvider;
use Symfony\Component\HttpClient\DecoratorTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class TraceableHttpClient implements HttpClientInterface
{
    use DecoratorTrait;

    public function __construct(HttpClientInterface $httpClient, private readonly TraceIdProvider $traceIdProvider)
    {
        $this->client = $httpClient;
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $options['headers']['X-Trace-Id'] = $this->traceIdProvider->getTraceId();
        return $this->client->request($method, $url, $options);
    }
}
