<?php declare(strict_types=1);

namespace SableSoft\OpenWeather;

use GuzzleHttp\Message\ResponseInterface;

/**
 * Class Response
 * @package SableSoft\OpenWeather
 */
class Response {

    const PARAM_ID = 'id';
    const PARAM_MAIN = 'main';
    const PARAM_NAME = 'name';
    const PARAM_WEATHER = 'weather';
    const PARAM_COORDINATES = 'coord';

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

    /**
     * @return string|null
     */
    public function getName() : ?string
    {
        return $this->getData(static::PARAM_NAME);
    }

    /**
     * @return array|null
     */
    public function getCoordinates() : ?array
    {
        return $this->getData(static::PARAM_COORDINATES);
    }

    /**
     * @return int|null
     */
    public function getId() : ?int
    {
        $id = $this->getData(static::PARAM_ID);
        return $id ? (int) $id : null;
    }

    /**
     * @return array|null
     */
    public function getWeather() : ?array
    {
        return $this->getData(static::PARAM_WEATHER);
    }

    /**
     * @return array|null
     */
    public function getMain() : ?array
    {
        return $this->getData(static::PARAM_MAIN);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getData(string $key)
    {
        $body = (array) $this->getBody();
        return $body[$key] ?? null;
    }
}
