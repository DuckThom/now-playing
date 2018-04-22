<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SpotifyService;

/**
 * Callback controller
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class CallbackController extends Controller
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
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        if ($request->has('error')) {
            return redirect('/')->withErrors('Authentication failed. Error code: ' . $request->input('error'));
        }

        try {
            $auth = $this->service->accessToken($request->input('code'));

            $request->session()->put($auth->toArray());
        } catch (\Exception $e) {
            \Log::warning($e->getMessage());

            return redirect('/')->withErrors('Authentication failed. Error message: ' . $e->getMessage());
        }

        return redirect('/');
    }
}