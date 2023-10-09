<?php

namespace App\Services;

use App\Exceptions\UnavailableServiceException;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use JsonException;

class WeatherService
{

    public function __construct(
        private GuzzleHttpClient    $http,
        private UserLocationService $userLocationService
    ) {
    }

    /**
     * @throws UnavailableServiceException
     */
    public function getWeather($request)
    {
        try {
            if (app()->environment('local')) {
                $ip = $this->userLocationService->getUserPublicIp();
            } else {
                $ip = $request->ip();
            }
            $geolocation = $this->userLocationService->getUserGeolocation($ip);

            return Cache::remember($geolocation['city'], now()->addHours(1), function () use ($geolocation) {
                $weatherData = $this->fetchWeatherData($geolocation['lat'], $geolocation['lon']);
                return $weatherData['main'];
            });
        } catch (\Throwable $e) {
            throw new UnavailableServiceException();
        }
    }

    /**
     *
     * @param float $lat
     * @param float $lon
     * @return array
     * @throws UnavailableServiceException
     * @throws GuzzleException|JsonException
     */
    private function fetchWeatherData(float $lat, float $lon): array
    {
        $apiUrl = config('services.weather.url') . "?lat=$lat&lon=$lon&appid=" . config('services.weather.api_key');
        $response = $this->http->get($apiUrl);

        if ($response->getStatusCode() !== 200) {
            throw new UnavailableServiceException();
        }

        return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }
}
