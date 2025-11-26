<?php

namespace esome\TraceIdBundle\EventListener;

use esome\TraceIdBundle\Services\TraceIdProvider;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

readonly class TraceIdTagResponseHeaderInjector
{
    public function __construct(private string $traceIdHeaderField, private TraceIdProvider $traceIdProvider)
    {
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $response->headers->set($this->traceIdHeaderField, $this->traceIdProvider->getTraceId());
    }
}
