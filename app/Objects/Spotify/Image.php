<?php

namespace App\Objects\Spotify;

class Image
{
    /**
     * @var int
     */
    public $height;

    /**
     * @var int
     */
    public $width;

    /**
     * @var string
     */
    public $url;

    /**
     * Image constructor.
     *
     * @param  int  $height
     * @param  int  $width
     * @param  string  $url
     */
    public function __construct(int $height, int $width, string $url)
    {
        $this->height = $height;
        $this->width = $width;
        $this->url = $url;
    }
}