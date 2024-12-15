<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Intervention\Image\Laravel\Facades\Image;

class FileUploadHelper
{
    public static function uploadFile($file, $moduleName, $fieldName, $type = 'default')
    {
        // Validate the file
        if (!$file->isValid() || $file->getSize() > 3072 * 1024) {
            return ['error' => 'Invalid file or file size exceeds 3MB'];
        }

        // Generate a new filename
        $newFileName = Carbon::now()->format('ymdhisu') . '.' . $file->getClientOriginalExtension();

        // Define the path
        $path = "public/$moduleName/$fieldName";

        // Ensure the directory exists
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }

        // Process the image if necessary
        if (in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
            $img = Image::read($file->getPathname());

            switch ($type) {
                case 'avatar':
                    $w = 512; $h = 512;
                    break;

                default:
                    $w = 1280; $h = 1280;
                    break;
            }

            $img->resize($w, $h, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Save the image to a temporary path
            $tempPath = sys_get_temp_dir() . '/' . $newFileName;
            $img->save($tempPath);

            // Store the image using Laravel's Storage facade
            $stored = Storage::putFileAs($path, new \Illuminate\Http\File($tempPath), $newFileName, 'public');

            // Delete the temporary file
            unlink($tempPath);

            if (!$stored) {
                return ['error' => 'File upload failed'];
            }
        } else {
            // Store the file in the public disk
            $stored = $file->storeAs($path, $newFileName, 'public');

            if (!$stored) {
                return ['error' => 'File upload failed'];
            }
        }

        // Generate the URL to access the file
        $url = "$moduleName/$fieldName/$newFileName";
        return ['message' => 'File uploaded successfully', 'url' => $url];
    }

    public static function deleteFile($path, $ignoreIfNotFound = false)
    {
        $path = 'public/' . $path;

        if($ignoreIfNotFound == true && !Storage::exists($path)){
            return ['error' => 'File not found (but ignored error)'];
        }

        // Check if the file exists
        if (Storage::exists($path)) {
            // Delete the file
            Storage::delete($path);
            return ['message' => 'File deleted successfully'.$path];
        } else {
            return ['error' => 'File not found'];
        }
    }
}
