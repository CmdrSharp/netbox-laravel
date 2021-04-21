<?php

namespace CmdrSharp\NetBox\Traits;

trait HasAttributes
{
    protected array $attributes = [];

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute(string $key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }
}
