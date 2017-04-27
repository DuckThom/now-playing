<?php

namespace App\Http\Controllers;

/**
 * Home controller
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class HomeController extends Controller
{
    /**
     * Main page handler.
     *
     * @return \Illuminate\View\View
     */
    public function handle()
    {
        if (session()->has('access_token')) {
            return redirect(route('playing'));
        }

        $auth_url = app('spotify')->getAuthorizeUrl([
            'scope' => config('spotify.scopes')
        ]);

        return view('welcome', compact('auth_url'));
    }
}