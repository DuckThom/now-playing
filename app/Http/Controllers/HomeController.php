<?php

namespace App\Http\Controllers;

use App\Services\SpotifyService;

/**
 * Home controller
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class HomeController extends Controller
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
     * Main page handler.
     *
     * @return \Illuminate\View\View
     */
    public function handle()
    {
        $auth_url = $this->service->getAuthUrl();

        return view('app', compact('auth_url'));
    }
}