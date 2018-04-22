<?php

namespace App\Objects\Spotify;

use Carbon\Carbon;

class Auth
{
    /**
     * @var string
     */
    public $access_token;

    /**
     * @var Carbon
     */
    public $expires_at;

    /**
     * @var string
     */
    public $refresh_token;

    /**
     * SpotifyAuth constructor.
     *
     * @param  string  $access_token
     * @param  string  $refresh_token
     * @param  int  $expires_in
     */
    public function __construct(string $access_token, string $refresh_token, int $expires_in)
    {
        $this->access_token = $access_token;
        $this->refresh_token = $refresh_token;
        $this->expires_at = Carbon::now()->addSeconds($expires_in);
    }

    /**
     * Convert the object to json.
     *
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'access_token' => $this->access_token,
            'expires_at' => $this->expires_at->timestamp,
            'refresh_token' => $this->refresh_token
        ];
    }
}