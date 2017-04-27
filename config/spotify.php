<?php

return [
    /**
     * The client id and secret for the API
     * Visit https://developer.spotify.com/ to get these values
     */
    'client_id' => env('SPOTIFY_CLIENT_ID'),
    'client_secret' => env('SPOTIFY_CLIENT_SECRET'),

    /**
     * A redirect URI defined in the Spotify app settings
     */
    'redirect_uri' => "http://playing.local/callback",

    /**
     * Scopes that are required for the app to work
     */
    'scopes' => [
        'user-read-playback-state'
    ]
];