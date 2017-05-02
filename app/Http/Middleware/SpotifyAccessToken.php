<?php

namespace App\Http\Middleware;

use Closure;
use SpotifyWebAPI\Session;

/**
 * Class SpotifyAccessToken
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class SpotifyAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('access_token') && session()->has('access_token_timeout') && session()->has('refresh_token')) {
            if (session('access_token_timeout') > (time() - 60)) {
                return $next($request);
            } else {
                if (session('refresh_token') !== "") {
                    if (app('spotify')->refreshAccessToken(session('refresh_token'))) {
                        $accessToken = app('spotify')->getAccessToken();
                        $accessTokenTimeout = app('spotify')->getTokenExpiration();
                        $refreshToken = app('spotify')->getRefreshToken();

                        session()->put('access_token', $accessToken);
                        session()->put('access_token_timeout', $accessTokenTimeout);
                        session()->put('refresh_token', $refreshToken);

                        return $next($request);
                    }
                }
            }
        }

        if (!$request->has('code')) {
            $options = [
                'scope' => config('spotify.scopes')
            ];

            if ($request->ajax()) {
                return response([
                    'code' => 400,
                    'refresh' => true,
                    'payload' => "Session expired or not created."
                ], 400);
            }

            return redirect()->away(
                app('spotify')->getAuthorizeUrl($options)
            );
        }

        $code = $request->input('code');

        if (app('spotify')->requestAccessToken($code)) {
            $accessToken = app('spotify')->getAccessToken();
            $accessTokenTimeout = app('spotify')->getTokenExpiration();
            $refreshToken = app('spotify')->getRefreshToken();

            session()->put('access_token', $accessToken);
            session()->put('access_token_timeout', $accessTokenTimeout);
            session()->put('refresh_token', $refreshToken);

            return $next($request);
        }

        return back();
    }
}