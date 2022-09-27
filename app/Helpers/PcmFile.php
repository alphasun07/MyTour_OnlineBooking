<?php

namespace App\Helpers;

class PcmFile
{

    public static function getExt($file)
    {
        // String manipulation should be faster than pathinfo() on newer PHP versions.
        $dot = strrpos($file, '.');

        if ($dot === false) {
            return '';
        }

        $ext = substr($file, $dot + 1);

        // Extension cannot contain slashes.
        if (strpos($ext, '/') !== false || (DIRECTORY_SEPARATOR === '\\' && strpos($ext, '\\') !== false)) {
            return '';
        }

        return $ext;
    }

    public static function stripExt($file)
    {
        return preg_replace('#\.[^.]*$#', '', $file);
    }

    public static function makeSafe($file)
    {
        // Remove any trailing dots, as those aren't ever valid file names.
        $file = rtrim($file, '.');

        $regex = array('#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#');

        return trim(preg_replace($regex, '', $file));
    }
}
