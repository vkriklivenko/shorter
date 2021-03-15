<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Link extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'long_url',
        'short_url',
        'clicks',
    ];

    /**
     * @param string $hash
     * @return mixed
     */
    public static function findUrl(string $hash)
    {
        return self::where('short_url', env('APP_URL') . $hash)->first();
    }

    /**
     * @param string $url
     * @return string
     * @throws \Exception
     */
    public static function generateShortLink(string $url)
    {
        if (self::checkIfAlreadyShort($url)) {
            return false;
        }
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $shortUrl = env('APP_URL') .  substr(str_shuffle($permitted_chars), 0, 10);

        return $shortUrl;
    }

    /**
     * @param string $url
     * @return bool
     */
    protected static function checkIfAlreadyShort(string $url)
    {
        $url_segment = env('APP_URL');
        if (strstr($url, $url_segment)) {
            return true;
        }

        return false;
    }
}
