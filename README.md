OpenWeather PHP Service
=====

PHP Service for the [Open Weather API](http://openweathermap.org/current)

## Installation

Using composer:
    
    "require": {
        "sablesoft/api-openweather": "*"
    }
    
Via CLI:   

    composer require sablesoft/api-openweather
    
## Configuration

Required configurations:

- The appId must be set in your application.
(Please see [here](http://openweathermap.org/appid) to get one)

Custom configurations:
- the Base URL and Default Guzzle Options.
(Please see [here](http://docs.guzzlephp.org/en/5.3/clients.html#request-options) for possible options)
    
## Usage

See below for sample initialization code:
    
    <?php
    
    include_once 'vendor/autoload.php';
    
    use SableSoft\OpenWeather\Service;

    $appId = 'your_appid_here';
    $options = [
        'endpount' => 'http://api.openweathermap.org' // already set as default
        'timeout' => 3, // default
        'connect_timeout' => 3 // default
    ];
    
    $service = Service::getInstance($appId, $baseUrl, $options);

    // get weather forecast by city:
    $response = $service->getByCity('Minsk');
    if ($response->isValid()) {
        print_r($response->getData());
    }
    
    // get weather forecast by coordinates:
    $response = $service->get(53.9006, 27.5590);
    if ($response->isValid()) {
        print_r($response->getData());
    }

    ?>
