<?php

namespace esome\TraceIdBundle\EventListener;

use esome\TraceIdBundle\Services\TraceId;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class TraceIdTagResponseHeaderInjector
{

    /** @var string */
    private $traceIdHeaderField;

    /** @var TraceId */
    private $traceIdProvider;

    public function __construct(string $traceIdHeaderField, TraceId $traceIdProvider)
    {
        $this->traceIdHeaderField = $traceIdHeaderField;
        $this->traceIdProvider = $traceIdProvider;
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $response->headers->set($this->traceIdHeaderField, $this->traceIdProvider->getTraceId());
    }
}
