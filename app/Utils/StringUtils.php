<?php

namespace App\Utils;

class StringUtils
{

    /**
     * Slugify a text
     * 
     * @param string $text
     * @return string
     */
    public static function slugify(string $text): string
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('/\s+/', '_', $text);
        $text = preg_replace('/[^A-Za-z0-9_]+/', '', $text);
        return strtoupper(trim($text));
    }
}
