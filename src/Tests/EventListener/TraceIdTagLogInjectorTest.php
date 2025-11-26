<?php

namespace esome\TraceIdBundle\Tests\EventListener;

use esome\TraceIdBundle\EventListener\TraceIdTagLogInjector;
use esome\TraceIdBundle\Services\TraceIdProvider;
use Monolog\DateTimeImmutable;
use Monolog\Level;
use Monolog\LogRecord;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RequestStack;

class TraceIdTagLogInjectorTest extends TestCase
{

    public function test_it_can_attach_trace_id_to_log_record(): void
    {
        $traceIdHeaderFieldName = 'X-Trace-Id';
        $traceIdLogFiledName = 'trace-id';
        $traceIdProvider = new TraceIdProvider($traceIdHeaderFieldName, new RequestStack());
        $logRecord = new LogRecord(new DateTimeImmutable(true), 'channel', Level::Info, 'test');

        $injector = new TraceIdTagLogInjector($traceIdLogFiledName, $traceIdProvider);
        $logWithTraceId = $injector->processRecord($logRecord);

        $this->assertEquals($logWithTraceId->extra[$traceIdLogFiledName], $traceIdProvider->getTraceId());
    }
}