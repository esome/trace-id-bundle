<?php

namespace esome\TraceIdBundle\EventListener;

use esome\TraceIdBundle\Services\TraceId;

/**
 * Class LogTrackProcessor
 * @package AppBundle\Helper
 */
class TraceIdTagLogInjector
{

    /** @var string */
    private $traceIdLogField;

    /** @var string */
    protected $traceId;

    public function __construct(string $traceIdLogField, TraceId $traceIdProvider)
    {
        $this->traceIdLogField = $traceIdLogField;
        $this->traceId = $traceIdProvider->getTraceId();
    }

    /**
     * Process single log record
     *
     * @param array $record
     * @return array
     */
    public function processRecord(array $record)
    {
        $record['extra'][$this->traceIdLogField] = $this->traceId;

        return $record;
    }
}
