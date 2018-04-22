<?php

namespace App\Objects\Spotify;

class Track
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $duration = 0;

    /**
     * @var Artist[]
     */
    public $artists = [];

    /**
     * @var Album
     */
    public $album;

    /**
     * Track constructor.
     *
     * @param  string  $id
     * @param  string  $name
     * @param  int  $duration
     * @param  array  $artists
     * @param  array  $album
     */
    public function __construct(string $id, string $name, int $duration = 0, array $artists = [], array $album)
    {
        $this->id = $id;
        $this->name = $name;
        $this->duration = $duration;

        foreach ($artists as $artist) {
            $this->artists[] = new Artist(
                $artist['id'],
                $artist['name'],
                $artist['uri']
            );
        }

        $this->album = new Album(
            $album['id'],
            $album['name'],
            $album['images'],
            $album['artists']
        );
    }
}