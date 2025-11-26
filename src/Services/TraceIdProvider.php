<?php

namespace esome\TraceIdBundle\Services;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Uid\Uuid;

readonly class TraceIdProvider
{
    private string $traceId;

    public function __construct(private string $traceIdHeaderField, RequestStack $requestStack)
    {
        $this->traceId = $this->resolveTraceIdFromRequest($requestStack) ?? Uuid::v4();
    }

    public function getTraceId(): string
    {
        return $this->traceId;
    }

    private function resolveTraceIdFromRequest(RequestStack $requestStack): ?string
    {
        if (empty($request = $requestStack->getCurrentRequest())) {
            return null;
        }

        return $request->headers->get($this->traceIdHeaderField);
    }

}
