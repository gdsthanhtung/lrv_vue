<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
            'module_name' => 'required|string',
            'field_name' => 'required|string',
            'file' => 'required|file|max:3072', // 3MB max size
        ]);

        $moduleName = $request->input('module_name');
        $fieldName = $request->input('field_name');
        $file = $request->file('file');

        // Generate a new filename
        $newFileName = Str::random(40) . '.' . $file->getClientOriginalExtension();

        // Define the path
        $path = "$moduleName/$fieldName";

        // Store the file in the public disk
        $stored = $file->storeAs($path, $newFileName, 'public');

        if ($stored) {
            $url = Storage::url($path."/".$newFileName);
            return response()->json(['message' => 'File uploaded successfully', 'url' => $url], 200);
        } else {
            return response()->json(['error' => 'File upload failed'], 500);
        }
    }
}
