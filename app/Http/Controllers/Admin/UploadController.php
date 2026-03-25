<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        // Handle batch client file uploads
        if ($request->query('batch') === 'clients') {
            return $this->uploadClientBatch($request);
        }

        // Handle batch step file uploads
        if ($request->query('batch') === 'steps') {
            return $this->uploadStepBatch($request);
        }

        try {
            if (!$request->hasFile('upload')) {
                return response()->json([
                    'uploaded' => false,
                    'error' => [
                        'message' => 'No file provided'
                    ]
                ], 400);
            }

            $file = $request->file('upload');
            return $this->saveFile($file);

        } catch (\Exception $e) {
            \Log::error('Upload error: ' . $e->getMessage());
            
            return response()->json([
                'uploaded' => false,
                'error' => [
                    'message' => 'Upload error: ' . $e->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * Handle batch uploads for client logos
     */
    private function uploadClientBatch(Request $request)
    {
        try {
            $uploadedFiles = [];
            $disk = Storage::disk('public');

            foreach ($request->allFiles() as $key => $files) {
                if (preg_match('/clients_files\[(\d+)\]/', $key, $matches)) {
                    $index = $matches[1];
                    $file = is_array($files) ? reset($files) : $files;
                    
                    if ($file && $file->isValid()) {
                        $extension = strtolower($file->getClientOriginalExtension());
                        $allowed = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
                        
                        if (in_array($extension, $allowed) && $file->getSize() <= 5120000) {
                            $filename = time() . '_' . uniqid() . '.' . $extension;
                            $path = $disk->putFileAs('ckeditor', $file, $filename);
                            
                            if ($path) {
                                $uploadedFiles[] = [
                                    'index' => $index,
                                    'path' => $path,
                                    'url' => asset('storage/' . $path)
                                ];
                            }
                        }
                    }
                }
            }

            return response()->json([
                'files' => $uploadedFiles
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Batch upload error: ' . $e->getMessage());
            
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle batch uploads for work process step images
     */
    private function uploadStepBatch(Request $request)
    {
        try {
            $uploadedFiles = [];
            $disk = Storage::disk('public');

            foreach ($request->allFiles() as $key => $files) {
                if (preg_match('/step_images\[(\d+)\]/', $key, $matches)) {
                    $index = $matches[1];
                    $file = is_array($files) ? reset($files) : $files;
                    
                    if ($file && $file->isValid()) {
                        $extension = strtolower($file->getClientOriginalExtension());
                        $allowed = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
                        
                        if (in_array($extension, $allowed) && $file->getSize() <= 5120000) {
                            $filename = time() . '_' . uniqid() . '.' . $extension;
                            $path = $disk->putFileAs('home-sections', $file, $filename);
                            
                            if ($path) {
                                $uploadedFiles[] = [
                                    'index' => $index,
                                    'path' => $path,
                                    'url' => asset('storage/' . $path)
                                ];
                            }
                        }
                    }
                }
            }

            return response()->json([
                'files' => $uploadedFiles
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Step batch upload error: ' . $e->getMessage());
            
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save a single file
     */
    private function saveFile($file)
    {
        if (!$file->isValid()) {
            return response()->json([
                'uploaded' => false,
                'error' => [
                    'message' => 'Invalid file'
                ]
            ], 400);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $allowed = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
        
        if (!in_array($extension, $allowed)) {
            return response()->json([
                'uploaded' => false,
                'error' => [
                    'message' => 'Only JPG, PNG, GIF, WebP allowed'
                ]
            ], 400);
        }

        if ($file->getSize() > 5120000) {
            return response()->json([
                'uploaded' => false,
                'error' => [
                    'message' => 'File too large (max 5MB)'
                ]
            ], 400);
        }

        // Store file with UUID-based name
        $filename = time() . '_' . uniqid() . '.' . $extension;
        
        // Use Storage facade directly
        $disk = Storage::disk('public');
        $path = $disk->putFileAs('ckeditor', $file, $filename);

        if (!$path) {
            return response()->json([
                'uploaded' => false,
                'error' => [
                    'message' => 'Could not save file'
                ]
            ], 500);
        }

        // Return URL for CKEditor (force HTTPS if on secure connection)
        $url = asset('storage/' . $path);
        if (request()->secure()) {
            $url = str_replace('http://', 'https://', $url);
        }
        
        return response()->json([
            'uploaded' => true,
            'url' => $url
        ], 200);
    }
}
