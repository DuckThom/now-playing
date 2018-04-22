<?php

namespace App\Objects\Spotify;

class Album
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
     * @var Image[]
     */
    public $images = [];

    /**
     * @var Artist[]
     */
    public $artists = [];

    /**
     * Album constructor.
     *
     * @param  string  $id
     * @param  string  $name
     * @param  array  $images
     * @param  array  $artists
     */
    public function __construct(string $id, string $name, array $images = [], array $artists = [])
    {
        $this->id = $id;
        $this->name = $name;

        foreach ($images as $image) {
            $this->images[] = new Image(
                $image['height'],
                $image['width'],
                $image['url']
            );
        }

        foreach ($artists as $artist) {
            $this->artists[] = new Artist(
                $artist['id'],
                $artist['name'],
                $artist['uri']
            );
        }
    }
}