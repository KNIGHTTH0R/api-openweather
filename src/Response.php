<?php declare(strict_types=1);

namespace SableSoft\OpenWeather;

use Exception;
use GuzzleHttp\Message\ResponseInterface;

/**
 * Class Response
 * @package SableSoft\OpenWeather
 */
class Response {

    const PARAM_WEATHER = 'weather';

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Parse out weather data from the response body
     *
     * @return array
     */
    public function getData() : array
    {
        try {
            $body = $this->getBody();

            if(isset($body[static::PARAM_WEATHER][0])) {
                return $body[static::PARAM_WEATHER][0];
            }

        } catch (Exception $e) {}

        return [];
    }

    /**
     * get the raw response body as json
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->response->json();
    }

    /**
     * @return bool
     */
    public function isValid() : bool
    {
        return $this->response->getStatusCode() == 200;
    }
}
