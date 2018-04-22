<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use App\Services\SpotifyService;

class CheckRefreshToken
{
    /**
     * @var SpotifyService
     */
    protected $service;

    /**
     * CallbackController constructor.
     *
     * @param  SpotifyService  $service
     */
    public function __construct(SpotifyService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ($request->session()->has('refresh_token')) {
            $expireTime = Carbon::createFromTimestamp($request->session()->get('expires_at'));

            if ($expireTime->isPast()) {
                try {
                    $auth = $this->service->refreshToken($request->session()->get('refresh_token'));

                    $request->session()->put($auth->toArray());
                } catch (\Exception $e) {
                    \Log::warning($e->getMessage());

                    return redirect('/')->withErrors('Authentication error. Error message: ' . $e->getMessage());
                }
            }
        }

        return $next($request);
    }
}