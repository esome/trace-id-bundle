<?php

namespace esome\TraceIdBundle\EventListener;

use esome\TraceIdBundle\Services\TraceIdProvider;
use Monolog\LogRecord;

readonly class TraceIdTagLogInjector
{
    public function __construct(private string $traceIdLogField, private TraceIdProvider $traceIdProvider)
    {
    }

    public function processRecord(LogRecord $record): LogRecord
    {
        $record->extra[$this->traceIdLogField] = $this->traceIdProvider->getTraceId();
        return $record;
    }
}
