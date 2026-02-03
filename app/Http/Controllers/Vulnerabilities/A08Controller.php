<?php

namespace App\Http\Controllers\Vulnerabilities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * A08: Software and Data Integrity Failures
 * 
 * This controller demonstrates data integrity vulnerabilities,
 * specifically around file uploads and content validation.
 */
class A08Controller extends Controller
{
    /**
     * VULNERABLE: File upload without proper validation
     * 
     * Vulnerabilities:
     * 1. No file type validation
     * 2. No file size limits
     * 3. No content verification
     * 4. Predictable file names
     * 5. Files stored in public directory
     */
    public function vulnerable(Request $request)
    {
        $message = null;
        $uploadedFile = null;
        $files = [];

        if ($request->isMethod('post') && $request->hasFile('file')) {
            $file = $request->file('file');
            
            // VULNERABILITY: No validation at all!
            // Accepting any file type, any size
            
            // VULNERABILITY: Keeping original filename
            // Could lead to path traversal or overwriting files
            $filename = $file->getClientOriginalName();
            
            // VULNERABILITY: Storing in public directory
            $path = $file->storeAs('vulnerable_uploads', $filename, 'public');
            
            $uploadedFile = [
                'original_name' => $filename,
                'path' => $path,
                'url' => Storage::url($path),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ];
            
            $message = "File uploaded successfully (no validation performed)!";
        }

        // List uploaded files
        $uploadedFiles = Storage::disk('public')->files('vulnerable_uploads');
        foreach ($uploadedFiles as $file) {
            $files[] = [
                'name' => basename($file),
                'url' => Storage::url($file),
                'size' => Storage::disk('public')->size($file),
            ];
        }

        return view('vulnerabilities.a08.vulnerable', [
            'message' => $message,
            'uploadedFile' => $uploadedFile,
            'files' => $files,
        ]);
    }

    /**
     * SECURE: File upload with comprehensive validation
     * 
     * Security measures:
     * 1. Validate file types (MIME type and extension)
     * 2. Limit file size
     * 3. Generate random filenames
     * 4. Verify file content matches declared type
     * 5. Store outside public directory when possible
     * 6. Calculate file hash for integrity verification
     */
    public function secure(Request $request)
    {
        $message = null;
        $uploadedFile = null;
        $files = [];

        if ($request->isMethod('post') && $request->hasFile('file')) {
            // SECURE: Comprehensive validation rules
            $validated = $request->validate([
                'file' => [
                    'required',
                    'file',
                    'max:2048', // 2MB max
                    'mimes:jpg,jpeg,png,gif,pdf,txt', // Allowed types
                ],
            ]);

            $file = $request->file('file');
            
            // SECURE: Additional content verification
            $mimeType = $file->getMimeType();
            $extension = $file->getClientOriginalExtension();
            
            // SECURE: Verify MIME type matches extension
            $allowedMimes = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'pdf' => 'application/pdf',
                'txt' => 'text/plain',
            ];
            
            if (!isset($allowedMimes[$extension]) || $allowedMimes[$extension] !== $mimeType) {
                return back()->withErrors(['file' => 'File type mismatch detected.']);
            }
            
            // SECURE: Generate random filename to prevent overwrites and enumeration
            $filename = Str::uuid() . '.' . $extension;
            
            // SECURE: Calculate hash for integrity verification
            $fileHash = hash_file('sha256', $file->getRealPath());
            
            // Store with generated name
            $path = $file->storeAs('secure_uploads', $filename, 'public');
            
            $uploadedFile = [
                'original_name' => $file->getClientOriginalName(),
                'stored_name' => $filename,
                'path' => $path,
                'url' => Storage::url($path),
                'mime_type' => $mimeType,
                'size' => $file->getSize(),
                'hash' => $fileHash,
            ];
            
            $message = "File uploaded securely with full validation!";
        }

        // List uploaded files
        $uploadedFiles = Storage::disk('public')->files('secure_uploads');
        foreach ($uploadedFiles as $file) {
            $files[] = [
                'name' => basename($file),
                'url' => Storage::url($file),
                'size' => Storage::disk('public')->size($file),
            ];
        }

        return view('vulnerabilities.a08.secure', [
            'message' => $message,
            'uploadedFile' => $uploadedFile,
            'files' => $files,
        ]);
    }
}
