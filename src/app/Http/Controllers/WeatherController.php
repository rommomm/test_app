<?php

namespace App\Http\Controllers;

use App\Exceptions\UnavailableServiceException;
use App\Http\Resources\UserWeatherResource;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function __construct(
        private WeatherService $weatherService
    ) {
    }

    /**
     * @throws UnavailableServiceException
     */
    public function getCurrentWeather(Request $request): JsonResponse
    {
        return response()->json(new UserWeatherResource($this->weatherService->getWeather($request)));
    }
}
