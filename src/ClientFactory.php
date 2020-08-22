<?php declare(strict_types=1);

namespace SableSoft\OpenWeather;

use GuzzleHttp\Client;

/**
 * Class ClientFactory
 * @package SableSoft\OpenWeather
 */
class ClientFactory
{
    const DEFAULT_ENDPOINT = 'http://api.openweathermap.org/';
    const DEFAULT_CONNECTION_TIMEOUT = 3;
    const DEFAULT_TIMEOUT = 3;

    const OPTION_ENDPOINT = 'endpoint';
    const OPTION_TIMEOUT = 'timeout';
    const OPTION_CONNECT_TIMEOUT = 'connect_timeout';

    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * ClientFactory constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->endpoint = $this->removeEndpoint($options);
        $this->options = $this->prepareOptions($options);
    }

    /**
     * @return Client
     */
    public function create() : Client
    {
        return new Client([
            'base_url' => $this->endpoint,
            'defaults' => $this->options
        ]);
    }

    /**
     * @return array|int[]
     */
    public function defaultOptions() : array
    {
        return [
            self::OPTION_TIMEOUT => self::DEFAULT_TIMEOUT,
            self::OPTION_CONNECT_TIMEOUT => self::DEFAULT_CONNECTION_TIMEOUT
        ];
    }


    /**
     * @param array $options
     * @return array
     */
    protected function prepareOptions(array $options) : array
    {
        foreach (static::defaultOptions() as $option => $value) {
            $options[$option] = $options[$option] ?? $value;
        }

        return $options;
    }

    /**
     * @param array $options
     * @return string
     */
    protected function removeEndpoint(array &$options) : string
    {
        $endpoint = $options[static::OPTION_ENDPOINT] ?? static::DEFAULT_ENDPOINT;
        unset($options[static::OPTION_ENDPOINT]);
        return $endpoint;
    }
}
