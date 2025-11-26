<?php

namespace esome\TraceIdBundle\Tests\Services;

use esome\TraceIdBundle\Services\TraceIdProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class TraceIdTest extends TestCase
{

    public function test_it_will_generate_new_trace_id(): void
    {
        $traceIdProvider = new TraceIdProvider('X-Trace-Id', new RequestStack());
        $traceId = $traceIdProvider->getTraceId();
        $this->assertNotEmpty($traceId);
    }

    public function test_single_instance_will_generate_trace_id_only_once(): void
    {
        $traceIdProvider = new TraceIdProvider('X-Trace-Id', new RequestStack());
        $traceId = $traceIdProvider->getTraceId();

        $this->assertSame($traceId, $traceIdProvider->getTraceId());
        $this->assertSame($traceId, $traceIdProvider->getTraceId());
        $this->assertSame($traceId, $traceIdProvider->getTraceId());
        $this->assertSame($traceId, $traceIdProvider->getTraceId());
    }

    public function test_it_will_reuse_trace_id_from_request(): void
    {
        $request = new Request;
        $request->headers->set('X-Trace-Id', 'dummy-trace-id');

        $requestStack = new RequestStack();
        $requestStack->push($request);

        $traceIdProvider = new TraceIdProvider('X-Trace-Id', $requestStack);
        $traceId = $traceIdProvider->getTraceId();
        $this->assertSame('dummy-trace-id', $traceId);
    }
}