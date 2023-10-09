<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;

class UserLocationService
{
    public function __construct(
        private GuzzleHttpClient $http
    ) {
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getUserPublicIp()
    {
        $publicIpResponse = $this->http->request('GET', config('services.weather.ip_ify_url'));
        $publicIpData = json_decode($publicIpResponse->getBody(), true, 512, JSON_THROW_ON_ERROR);

        return $publicIpData['ip'] ?? null;
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getUserGeolocation(string $ip)
    {
        $geolocationData = $this->http->request('GET', config('services.weather.ip_api_url') . $ip);
        $geolocation = json_decode($geolocationData->getBody(), true, 512, JSON_THROW_ON_ERROR);

        return $geolocation['status'] === 'success' ? $geolocation : null;
    }
}
