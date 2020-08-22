<?php declare(strict_types=1);

namespace SableSoft\OpenWeather;

use GuzzleHttp\Client;

/**
 * Class Request
 * @package SableSoft\OpenWeather
 */
class Request {

    const ROUTE_DEFAULT = '/data/2.5/weather';
    const ROUTE_DAILY   = '/data/2.5/forecast/daily';

    const PARAM_COUNT = 'cnt';
    const PARAM_APPID = 'appid';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $appId;

    /**
     * @param Client $client
     * @param string $appId
     */
    public function __construct(Client $client, string $appId)
    {
        $this->client = $client;
        $this->appId = $appId;
    }

    /**
     * Run the http request
     *
     * @param $queryParams
     * @return Response
     */
    public function run(array $queryParams) : Response
    {
        $queryParams[static::PARAM_APPID] = $this->appId;

        return $this->callGet(
            $this->getRoute($queryParams),
            ['query' => $queryParams]
        );
    }

    /**
     * Execute the get method on the guzzle client and create a response
     *
     * @param string $route
     * @param array $options
     * @return Response
     */
    public function callGet(string $route, array $options) : Response
    {
        $response = $this->client->get($route, $options);

        return new Response($response);
    }

    /**
     * @param array $queryParams
     * @return string
     */
    protected function getRoute(array $queryParams) : string
    {
        return (isset($queryParams[static::PARAM_COUNT]) && $queryParams[static::PARAM_COUNT] > 1) ?
            static::ROUTE_DAILY :
            static::ROUTE_DEFAULT;
    }
}
