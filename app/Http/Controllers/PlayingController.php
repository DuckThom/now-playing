<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Services\SpotifyService;
use GuzzleHttp\Exception\BadResponseException;

/**
 * Playing controller
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class PlayingController extends Controller
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
     * Playing page
     *
     * @return \Illuminate\View\View
     */
    public function handle()
    {
        return view('playing');
    }

    /**
     * Get the data from Spotify
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function fetch()
    {
        return response()->json([
            'song' => $this->service->currentSong(),
            'code' => 200
        ]);
    }
}