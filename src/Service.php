<?php declare(strict_types=1);

namespace SableSoft\OpenWeather;

use InvalidArgumentException;
use GuzzleHttp\Exception\RequestException;

/**
 * Class Service
 * @package SableSoft\OpenWeather
 */
class Service {

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Create an service instance.
     *
     * @param string $appId
     * @param array $options
     * @return Service
     * @throws InvalidArgumentException
     */
    public static function getInstance(string $appId, array $options = []) : Service
    {
        $client = (new ClientFactory($options))->create();
        $request = new Request($client, $appId);

        return new Service($request);
    }



    /**
     * Get weather by the provided $latitude and $longitude
     *
     * @param float $latitude
     * @param float $longitude
     * @param string $unit
     * @param int $count
     * @return Response
     * @throws RequestException
     */
    public function get(
        float $latitude,
        float $longitude,
        string $unit = 'imperial',
        int $count = 1
    ) {
        $params = array(
            'lat' => $latitude,
            'lon' => $longitude,
            'units' => $unit,
            'cnt' => $count
        );

        return $this->request->run($params);
    }

    /**
     * Get weather by the provided $city name
     *
     * @param string $city
     * @param string $country
     * @param string $unit
     * @return Response
     * @throws RequestException
     */
    public function getByCity(
        string $city,
        string $country = null,
        string $unit = 'imperial'
    ) {
        $query = $country ? "$city,$country" : $city;
        $params = array(
            'q' => $query,
            'units' => $unit
        );

        return $this->request->run($params);
    }
}
