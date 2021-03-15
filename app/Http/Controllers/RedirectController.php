<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 3/15/2021
 * Time: 5:07 PM
 */

namespace App\Http\Controllers;


use App\Models\Link;
use Illuminate\Http\Request;

class RedirectController
{
    /**
     * @param Request $request
     * @param string $urlHash
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirect(Request $request, string $urlHash)
    {
        $shortedUrl = Link::findUrl($urlHash);
        if (!$shortedUrl) {
            abort(404);
        }

        $shortedUrl->clicks = ++$shortedUrl->clicks;
        $shortedUrl->save();

        return redirect($shortedUrl->long_url);
    }
}