<?php

namespace CmdrSharp\NetBox\Traits;

use CmdrSharp\NetBox\Exceptions\DynamicAssignmentException;
use Psr\Http\Message\ResponseInterface;
use stdClass;

trait HandlesNetBoxResults
{
    /**
     * @param ResponseInterface $response
     * @return stdClass
     */
    protected function getOnlyResult(ResponseInterface $response): stdClass
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $class = get_class($this);
        $caller = $backtrace[1]['function'] ?? 'UNKNOWN';

        if($response->getStatusCode() !== 200) {
            throw new DynamicAssignmentException(
                sprintf('[%s::%s] - NetBox API lookup returned HTTP [%s]', $class, $caller, $response->getStatusCode())
            );
        }

        $results = json_decode($response->getBody());

        if($results->count > 1) {
            throw new DynamicAssignmentException(sprintf(
                '[%s::%s] - NetBox API Lookup failed as multiple groups (%s in total) match the target string',
                $class, $caller, $results->count
            ));
        }

        if($results->count < 1) {
            throw new DynamicAssignmentException(
                sprintf('[%s::%s] - NetBox API Lookup failed as no resources match the search query', $class, $caller)
            );
        }

        if(!isset($results->results[0]->id) || !$results->results[0] instanceof stdClass) {
            throw new DynamicAssignmentException(
                sprintf('[%s::%s] - NetBox API Lookup failed as no resources match the search query', $class, $caller)
            );
        }

        return $results->results[0];
    }
}