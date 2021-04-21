<?php

namespace CmdrSharp\NetBox\Traits;

trait HasFillable
{
    protected array $fillable = [];

    /**
     * @return array
     */
    public function getFillable(): array
    {
        return $this->fillable;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isFillable(string $key): bool
    {
        if (in_array($key, $this->getFillable())) {
            return true;
        }

        return false;
    }

    /**
     * @param  array  $attributes
     * @return array
     */
    protected function fillableFromArray(array $attributes): array
    {
        if (count($this->getFillable()) > 0) {
            return array_intersect_key($attributes, array_flip($this->getFillable()));
        }

        return $attributes;
    }
}