<?php

namespace LaravelFCM\Request;

/**
 * Class BaseRequest.
 */
abstract class BaseRequest
{
    /**
     * @internal
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @internal
     *
     * @var array
     */
    protected $config;

    /**
     * BaseRequest constructor.
     */
    public function __construct()
    {
        $this->config = app('config')->get('fcm.http', []);
    }

    /**
     * Build the header for the request.
     *
     * @return array
     */
    protected function buildRequestHeader($prefix = '')
    {
        return [
            'Authorization' => 'key='.$this->config['server_key' . $prefix],
            'Content-Type' => 'application/json',
            'project_id' => $this->config['sender_id' . $prefix],
        ];
    }

    /**
     * Build the body of the request.
     *
     * @return mixed
     */
    abstract protected function buildBody();

    /**
     * Return the request in array form.
     *
     * @return array
     */
    public function build($prefix = '')
    {
        return [
            'headers' => $this->buildRequestHeader($prefix),
            'json' => $this->buildBody(),
        ];
    }
}
