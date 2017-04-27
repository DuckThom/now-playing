<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Make a url.
     *
     * @param  string $base
     * @param  array $parameters
     * @return string
     */
    protected function makeUrl($base, $parameters = [])
    {
        $url = $base . ($parameters ? '?' : '');

        foreach ($parameters as $key => $value) {
            $url .= $key . "=" . $value . "&";
        }

        return $url;
    }
}
