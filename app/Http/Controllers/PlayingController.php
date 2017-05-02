<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

/**
 * Playing controller
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class PlayingController extends Controller
{
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
        if (!session()->has('access_token') || !request()->ajax()) {
            return redirect('/');
        }

        $client = new Client;
        try {
            $response = $client->get("https://api.spotify.com/v1/me/player/currently-playing", [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('access_token')
                ]
            ]);

            $refresh = false;
            $code = $response->getStatusCode();
            $payload = $response->getBody()->getContents();
        } catch (BadResponseException $e) {
            $refresh = false;
            $code = $e->getResponse()->getStatusCode();
            $payload = [
                "message" => "Loading from Spotify API failed.",
            ];
        }

        return response([
            'code' => $code,
            'success' => $code >= 200 && $code < 300,
            'refresh' => $refresh,
            'payload' => $payload
        ]);
    }
}