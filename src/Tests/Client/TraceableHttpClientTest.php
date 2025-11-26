<?php

namespace esome\TraceIdBundle\Tests\Client;

use esome\TraceIdBundle\Client\TraceableHttpClient;
use esome\TraceIdBundle\Services\TraceIdProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class TraceableHttpClientTest extends TestCase
{
    public function testRequestWillContainTraceIdHeader(): void {
        $mockResponse = new MockResponse('', ['http_code' => 200]);
        $httpClient = new MockHttpClient($mockResponse, 'https://example.com');

        $traceIdHeaderField = 'X-Trace-Id';
        $traceIdProvider = new TraceIdProvider($traceIdHeaderField, new RequestStack());

        $traceableHttpClient = new TraceableHttpClient($httpClient, $traceIdProvider);
        $traceableHttpClient->request('GET', 'https://example.com');

        $requestHeaders = $mockResponse->getRequestOptions()['headers'];

        $expectedHeader = $traceIdHeaderField . ": " . $traceIdProvider->getTraceId();
        $this->assertContains($expectedHeader, $requestHeaders);
    }
}
