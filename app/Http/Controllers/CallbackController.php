<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI\SpotifyWebAPI;

/**
 * Callback controller
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class CallbackController extends Controller
{

    public function handle(Request $request)
    {
        return redirect('/');
    }
}