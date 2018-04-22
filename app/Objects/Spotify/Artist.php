<?php

namespace App\Objects\Spotify;

class Artist
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
     * @var string
     */
    public $uri;

    /**
     * Artist constructor.
     *
     * @param  string  $id
     * @param  string  $name
     * @param  string  $uri
     */
    public function __construct(string $id, string $name, string $uri)
    {
        $this->id = $id;
        $this->name = $name;
        $this->uri = $uri;
    }
}