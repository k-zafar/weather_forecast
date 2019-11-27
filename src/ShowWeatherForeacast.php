<?php

namespace Drupal\weather_forecast;
use GuzzleHttp\Exception\RequestException;

/**
 * Class ShowWeatherForeacast.
 *
 * @package Drupal\weather_forecast
 */
class ShowWeatherForeacast {
  public function showWeatherForeacast($city) {
    // Initialising weather values
    $weather_forecast['wind']  = '';
    $weather_forecast['humidity'] = '';
    $weather_forecast['pressure'] = '';
    $weather_forecast['temp'] = '';
    $weather_forecast['weather'] = '';
    $weather_forecast['city'] = '';

    // Returning  when city is empty or not entered
    if(empty($city)){
        return $weather_forecast;
    }

    $client = \Drupal::httpClient();
    
    try {
        // Calling Weather API
        $request = $client->get('http://api.openweathermap.org/data/2.5/weather', [
                'query' => [
                'q' => $city,
                'APPID' => 'd5b252a4a2dcb9addc5b1d38a962fc0f',
                'units' => 'imperial',
            ],
        ]);

        // Extracting weather forecast
        $response = json_decode($request->getBody(), true);
        $weather_forecast['wind']  = $response['wind']['speed'];
        $weather_forecast['humidity'] = $response['main']['humidity'];
        $weather_forecast['pressure'] = $response['main']['pressure'];
        $weather_forecast['temp'] = $response['main']['temp'];
        $weather_forecast['weather'] = $response['weather'][0]['main'];
        $weather_forecast['city'] = $city;
    }
    catch (RequestException $e) {
        // Add Drupal Log
    }
	
    return $weather_forecast;
  }
}
