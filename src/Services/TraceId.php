<?php

namespace esome\TraceIdBundle\Services;

use Symfony\Component\HttpFoundation\Request;

class TraceId
{

    /** @var string */
    private $traceIdHeaderField;

    /** @var string */
    private $traceId;

    public function __construct(string $traceIdHeaderField)
    {
        $this->traceIdHeaderField = $traceIdHeaderField;
        $this->traceId = uniqid();
    }

    public function getTraceId(Request $currentRequest = null): string
    {
        if (empty($request = $currentRequest ?? Request::createFromGlobals())) {
            return $this->traceId;
        }

        return $request->headers->get($this->traceIdHeaderField) ?? $this->traceId;
    }
}