<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class FileHelper
{
    public static function saveFileStorage($file, $folder, $public=true)
    {
        if (empty($file)) {
            return;
        }

        $extension = $file->getClientOriginalExtension();
        $file_name = explode('.', $file->getClientOriginalName())[0];
        $file_name = sprintf(date('YmdHi') . '_' . $file_name . '.%s', $extension);
        $storage = Storage::disk($public ? 'public' : '');
        $check_directory = $storage->exists($folder);
        if (!$check_directory) {
            $storage->makeDirectory($folder);
        }
        $storage->put($folder . '/' . $file_name, File::get($file));
        return $file_name;
    }

    public static function removeFile($file_remove, $folder)
    {
        try {
            if (empty($file_remove)) {
                return;
            }
            $file_path = $folder . '/' . $file_remove;
            if (Storage::exists($file_path)) {
                Storage::delete($file_path);
            }
            return;
        } catch (\Exception $e) {
            Log::info('---Remove File Storage---');
            Log::error($e->getMessage());
        }
    }

    public function removeFolder($folder)
    {
        try {
            if (empty($folder)) {
                return false;
            }
            if (Storage::path($folder)) {
                return Storage::deleteDirectory($folder);
            }
            return false;
        } catch (\Exception $e) {
            Log::info('---Remove File Storage---');
            Log::error($e->getMessage());
            return false;
        }
    }

    public function downloadFile($path)
    {
        try {
            if (Storage::exists($path)) {
                return Storage::download($path);
            } else {
                return false;
            }
        } catch (\Exception $e) {
            Log::info('---Download File---');
            Log::error($e->getMessage());
            return false;
        }
    }
}
