<?php

// app/Http/Controllers/FileUploadController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:2048',
        ]);

        // Handle the file upload
        if ($request->file('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');

            // Return success response
            return response()->json([
                'message' => 'File uploaded successfully',
                'file_path' => $filePath
            ], 200);
        }

        // Return error response
        return response()->json(['message' => 'File upload failed'], 400);
    }
}
