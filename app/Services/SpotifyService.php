<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Objects\Spotify\Auth;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Auth\AuthenticationException;

class SpotifyService
{
    const URL_SPOTIFY_AUTH = 'https://accounts.spotify.com';

    const ENDPOINT_SPOTIFY_AUTH = '/authorize';
    const ENDPOINT_SPOTIFY_TOKEN = '/api/token';

    const GRANT_TYPE_AUTH = 'authorization_code';
    const GRANT_TYPE_REFRESH = 'refresh_token';

    /**
     * @var Client
     */
    protected $client;

    /**
     * SpotifyService constructor.
     *
     * @param  Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = new Client;
    }

    /**
     * Get the url for authentication.
     *
     * @return string
     */
    public function getAuthUrl(): string
    {
        return static::URL_SPOTIFY_AUTH .
            static::ENDPOINT_SPOTIFY_AUTH .
            '?' .
            http_build_query([
                'scope' => join(',', config('spotify.scopes')),
                'client_id' => config('spotify.client_id'),
                'redirect_uri' => config('spotify.redirect_uri'),
                'response_type' => 'code'
            ]);
    }

    /**
     * Get a new access token.
     *
     * @param  string  $code
     * @return Auth
     * @throws AuthenticationException
     */
    public function accessToken(string $code): Auth
    {
        return $this->createSpotifyAuth(
            $this->getToken($code, static::GRANT_TYPE_AUTH)
        );
    }

    /**
     * Refresh an access token.
     *
     * @param  string  $token
     * @return Auth
     * @throws AuthenticationException
     */
    public function refreshToken(string $token): Auth
    {
        return $this->createSpotifyAuth(
            $this->getToken($token, static::GRANT_TYPE_REFRESH)
        );
    }

    /**
     * Create a Spotify auth object.
     *
     * @param  array  $data
     * @return Auth
     */
    protected function createSpotifyAuth(array $data): Auth
    {
        return new Auth(
            $data['access_token'],
            $data['refresh_token'] ?? session('refresh_token'),
            $data['expires_in']
        );
    }

    /**
     * Get an access token.
     *
     * @param  string  $token
     * @param  string  $grantType
     * @return array
     * @throws AuthenticationException
     */
    protected function getToken(string $token, string $grantType): array
    {
        switch ($grantType) {
            case static::GRANT_TYPE_REFRESH:
                $key = 'refresh_token';
                break;
            case static::GRANT_TYPE_AUTH:
            default:
                $key = 'code';
        }

        $response = $this->request(static::ENDPOINT_SPOTIFY_TOKEN, 'post', [
            'grant_type' => $grantType,
            'redirect_uri' => config('spotify.redirect_uri'),
            $key => $token,
        ], [
            'Authorization' => 'Basic ' . base64_encode(sprintf('%s:%s', config('spotify.client_id'), config('spotify.client_secret')))
        ]);

        $json = json_decode((string) $response->getBody(), true);

        if (isset($json['error'])) {
            throw new AuthenticationException($json['error_description']);
        }

        return $json;
    }

    /**
     * Make a request to the Spotify api.
     *
     * @param  string  $endpoint
     * @param  string  $type
     * @param  array  $data
     * @param  array  $headers
     * @return ResponseInterface
     */
    protected function request(string $endpoint, string $type = 'get', $data = [], array $headers = []): ResponseInterface
    {
        if (strpos($endpoint, 'http') === false) {
            $endpoint = static::URL_SPOTIFY_AUTH . $endpoint;
        }

        if (empty($headers)) {
            $headers = [
                'Authorization' => 'Bearer ' . session('access_token')
            ];
        }

        return $this->client->$type($endpoint, [
            'http_errors' => false,
            'headers' => $headers,
            'form_params' => $data
        ]);
    }
}