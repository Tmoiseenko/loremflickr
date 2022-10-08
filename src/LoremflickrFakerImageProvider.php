<?php

namespace Tmoiseenko\Loremflickr;

use Faker\Provider\Base;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class LoremflickrFakerImageProvider
{
    /**
     * @var string
     */
    public const BASE_URL = 'https://loremflickr.com';

    /**
     * Generate the URL that will return a random image
     *
     * @example 'https://loremflickr.com/320/240/dog'
     *
     * @param int         $width
     * @param int         $height
     * @param string|array|null $category
     *
     * @return string
     */
    public static function imageUrl(
        $width = 640,
        $height = 480,
        $category = null
    ) {
        $size = sprintf('%d/%d', $width, $height);


        if ($category !== null) {
            $category = is_array($category) ? implode(',', $category) : $category;
        } else {
            $category = '';
        }

        return sprintf(
            '%s/%s/%s',
            self::BASE_URL,
            $size,
            $category,
        );
    }


    /**
     * Generate the URL that will return a random image
     *
     * @param int         $width
     * @param int         $height
     * @param string|null $category
     *
     * @return string
     */
    public static function loremflickrImage(
        $dir = null,
        $width = 640,
        $height = 480,
        $category = null,
        $fullPath = false
    ) {
        $dir = null === $dir ? sys_get_temp_dir() : $dir; // GNU/Linux / OS X / Windows compatible
        // Validate directory path
        if (!is_dir($dir) || !is_writable($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        // Generate a random filename. Use the server address so that a file
        // generated at the same time on a different server won't have a collision.
        $name = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true));
        $filename = sprintf('%s.%s', $name, 'jpg');
        $filepath = $dir . DIRECTORY_SEPARATOR . $filename;

        $url = static::imageUrl($width, $height, $category);

        if ($data = file_get_contents($url)) {
            Storage::put('public/' . $filepath, $data);
        }

        return $fullPath ? 'storage/' . $filepath : $filename;
    }
}
