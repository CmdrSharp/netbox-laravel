<?php

namespace CmdrSharp\NetBox;

use CmdrSharp\GuzzleApi\Client;
use CmdrSharp\GuzzleApi\RequestInterface;
use CmdrSharp\NetBox\Contracts\NetBoxInterface;
use CmdrSharp\NetBox\Exceptions\MassAssignmentException;
use CmdrSharp\NetBox\Traits\HasAttributes;
use CmdrSharp\NetBox\Traits\HasFillable;
use Psr\Http\Message\ResponseInterface;

abstract class NetBox implements NetBoxInterface
{
    use HasFillable,
        HasAttributes;

    /** @var RequestInterface */
    protected RequestInterface $api;

    /**
     * NetBox constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->api = (new Client)->make(config('netbox.host'))->withOptions([
            'http_errors' => false,
            'verify' => config('netbox.verify_peer'),
        ])->withHeaders([
            'Authorization' => 'Token ' . config('netbox.token'),
            'Accept' => 'application/json'
        ]);

        $this->fill($attributes);
    }

    /**
     * @param string $uri
     * @param string $method
     * @param array $body
     * @return ResponseInterface
     */
    protected function request(string $uri, $method = 'get', $body = []): ResponseInterface
    {
        return $this->api->to($uri)->withBody($body)->{$method}();
    }

    /**
     * @return ResponseInterface
     */
    public static function all(): ResponseInterface
    {
        return (new static)->request(static::API_PATH);
    }

    /**
     * @param int $id
     * @return ResponseInterface
     */
    public static function get(int $id): ResponseInterface
    {
        return (new static)->request(static::API_PATH . "{$id}/");
    }

    /**
     * @param string $query
     * @return ResponseInterface
     */
    public static function where(string $query): ResponseInterface
    {
        return (new static)->request(static::API_PATH . $query . '&limit=0');
    }

    /**
     * @param string $name
     * @return ResponseInterface
     */
    public static function whereName(string $name): ResponseInterface
    {
        return self::where("?name={$name}");
    }

    /**
     * @return ResponseInterface
     */
    public function create(): ResponseInterface
    {
        return $this->request(static::API_PATH, 'post', $this->getAttributes());
    }

    /**
     * @param int $id
     * @return ResponseInterface
     */
    public static function delete(int $id): ResponseInterface
    {
        return (new static)->request(static::API_PATH . "{$id}/", 'delete');
    }

    /**
     * @param array $attributes
     * @return $this
     * @throws MassAssignmentException
     */
    public function fill(array $attributes): NetBox
    {
        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            if(!$this->isFillable($key)) {
                throw new MassAssignmentException(sprintf(
                    'Add [%s] to fillable property to allow mass assignment on [%s].',
                    $key, get_class($this)
                ));
            }

            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value): void
    {
        $this->setAttribute($key, $value);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->attributes[$key];
    }
}