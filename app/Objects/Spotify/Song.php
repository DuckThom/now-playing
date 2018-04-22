<?php

namespace App\Objects\Spotify;

class Song
{
    /**
     * @var bool
     */
    public $is_playing = false;

    /**
     * @var int
     */
    public $progress = 0;

    /**
     * @var Track
     */
    public $track;

    /**
     * Song constructor.
     *
     * @param  bool  $playing
     * @param  int  $progress
     * @param  array|null  $item
     */
    public function __construct(bool $playing = false, int $progress = 0, ?array $item)
    {
        $this->is_playing = $playing;
        $this->progress = $progress;
        $this->track = new Track(
            $item['id'],
            $item['name'],
            $item['duration_ms'],
            $item['artists'],
            $item['album']
        );
    }
}