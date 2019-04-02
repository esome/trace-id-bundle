<?php

namespace esome\TraceIdBundle\Tests\EventListener;

use esome\TraceIdBundle\EventListener\TraceIdTagLogInjector;
use esome\TraceIdBundle\Services\TraceId;
use PHPUnit\Framework\TestCase;

class TraceIdTagLogInjectorTest extends TestCase
{

    public function test_it_can_attach_trace_id_to_log_record()
    {
        $traceIdHeaderFieldName = 'X-ELI-TRACE-ID';
        $traceIdLogFiledName = 'ELI-TRACE-ID';
        $traceIdGenerator = new TraceId($traceIdHeaderFieldName);
        $logRecord = ['message' => 'test'];

        $injector = new TraceIdTagLogInjector($traceIdLogFiledName, $traceIdGenerator);
        $logWithTraceId = $injector->processRecord($logRecord);

        $this->assertEquals($logWithTraceId['extra'][$traceIdLogFiledName], $traceIdGenerator->getTraceId());
    }
}