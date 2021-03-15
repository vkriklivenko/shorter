<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 3/15/2021
 * Time: 3:04 PM
 */

namespace App\Http\Controllers\API;


use App\Models\Link;
use Illuminate\Http\Request;

class LinkController
{
    public const DEFAULT_COUNT_CLICKS = 0;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => ['required', 'regex:/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/']
        ]);

        $url = $request->get('url');

        $shorted = Link::generateShortLink($url);
        if (!$shorted) {
            $errors = [
                'url' => ['URL has been already shorted']
            ];
            return response()->json([
                'errors' => $errors
            ], 422);
        }
        Link::create([
           'short_url' => $shorted,
           'long_url'  => $url,
            'clicks'   => self::DEFAULT_COUNT_CLICKS
        ]);

        return $shorted;
    }
}