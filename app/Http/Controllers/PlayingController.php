<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

/**
 * Playing controller
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class PlayingController extends Controller
{
    public function handle()
    {
        return view('playing');
    }

    public function fetch()
    { // curl -X GET "https://api.spotify.com/v1/me/player" -H "Authorization: Bearer {your access token}"
        if (!session()->has('access_token')) {
            return redirect('/');
        }

        $client = new Client;
        $response = $client->get("https://api.spotify.com/v1/me/player/currently-playing", [
            'headers' => [
                'Authorization' => 'Bearer ' . session('access_token')
            ]
        ]);

        $code = $response->getStatusCode();

        return response([
            'code' => $code,
            'success' => $code >= 200 && $code < 300,
            'payload' => $response->getBody()->getContents()
        ]);
    }
}