<?php

namespace CmdrSharp\NetBox\Contracts;

use Psr\Http\Message\ResponseInterface;

interface NetBoxInterface
{
    /**
     * @return ResponseInterface
     */
    public static function all(): ResponseInterface;

    /**
     * @param int $id
     * @return ResponseInterface
     */
    public static function get(int $id): ResponseInterface;

    /**
     * @param string $query
     * @return ResponseInterface
     */
    public static function where(string $query): ResponseInterface;

    /**
     * @return ResponseInterface
     */
    public function create(): ResponseInterface;
}
