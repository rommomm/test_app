<?php

namespace App\Http\Middleware;

use App\Exceptions\AccessDeniedIpException;
use App\Exceptions\UnableToDetermineIpException;
use App\Services\UserLocationService;
use Closure;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class CheckUserIpMiddleware
{
    public const ACCESS_DENIED_IP = "Access denied. User IP is not from Ukraine.";
    public const UNABLE_USER_IP = "Unable to determine user IP.";
    protected UserLocationService $userLocationService;

    public function __construct(UserLocationService $userLocationService)
    {
        $this->userLocationService = $userLocationService;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws UnableToDetermineIpException
     * @throws AccessDeniedIpException
     */
    public function handle($request, Closure $next)
    {
        if (app()->environment('local')) {
            $userIp = $this->userLocationService->getUserPublicIp();
        } else {
            $userIp = $request->ip();
        }

        if ($userIp) {
            $geolocation = $this->userLocationService->getUserGeolocation($userIp);

            if (!$geolocation || $geolocation['country'] !== 'Ukraine') {
                throw new AccessDeniedIpException();
            }
        } else {
            throw new UnableToDetermineIpException();
        }

        return $next($request);
    }
}
