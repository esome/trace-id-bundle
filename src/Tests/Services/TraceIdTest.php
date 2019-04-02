<?php

namespace esome\TraceIdBundle\Tests\Services;

use esome\TraceIdBundle\Services\TraceId;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class TraceIdTest extends TestCase
{

    public function test_it_will_generate_new_trace_id()
    {
        $traceId = (new TraceId('X-ELI-TRACE-ID'))->getTraceId();

        $this->assertNotEmpty($traceId);
    }

    public function test_single_instance_will_generate_trace_id_only_once()
    {
        $instance = new TraceId('X-ELI-TRACE-ID');
        $traceId = $instance->getTraceId();

        $this->assertEquals($traceId, $instance->getTraceId());
        $this->assertEquals($traceId, $instance->getTraceId());
        $this->assertEquals($traceId, $instance->getTraceId());
        $this->assertEquals($traceId, $instance->getTraceId());
    }

    public function test_it_will_reuse_trace_id_from_request()
    {
        $request = new Request;
        $request->headers->set('X-ELI-TRACE-ID', 'dummy-trace-id');

        $traceId = (new TraceId('X-ELI-TRACE-ID'))->getTraceId($request);

        $this->assertEquals($traceId, 'dummy-trace-id');
    }
}