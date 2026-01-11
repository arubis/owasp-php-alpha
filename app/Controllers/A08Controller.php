<?php
/**
 * A08: Software and Data Integrity Failures
 */

class A08Controller extends BaseController {
    public function __construct() {
        require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
        AuthMiddleware::requireAuth();
    }

    /**
     * VULNERABLE: File upload/update without integrity validation
     */
    public function vulnerable() {
        $message = '';
        $uploadedFile = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $file = $_FILES['file'];
            
            if ($file['error'] === UPLOAD_ERR_OK) {
                $uploadPath = __DIR__ . '/../../storage/uploads/';
                $filename = basename($file['name']);
                $targetPath = $uploadPath . $filename;
                
                // VULNERABILITY: No integrity validation
                // No hash/signature verification
                // No file type validation beyond extension
                // Trusting user-supplied file completely
                
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $message = "File uploaded successfully (VULNERABLE: No integrity check)";
                    $uploadedFile = [
                        'name' => $filename,
                        'size' => $file['size'],
                        'path' => $targetPath
                    ];
                } else {
                    $message = "Upload failed";
                }
            }
        }

        $this->render('a08/vulnerable', [
            'message' => $message,
            'uploadedFile' => $uploadedFile
        ]);
    }

    /**
     * SECURE: Hash/signature verification (conceptual)
     */
    public function secure() {
        $message = '';
        $uploadedFile = null;
        $fileHash = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $file = $_FILES['file'];
            
            if ($file['error'] === UPLOAD_ERR_OK) {
                // SECURE: Calculate hash of uploaded file
                $fileContent = file_get_contents($file['tmp_name']);
                $fileHash = hash('sha256', $fileContent);
                
                // SECURE: Verify file type (example: only allow images)
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);
                
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                
                if (!in_array($mimeType, $allowedTypes)) {
                    $message = "Invalid file type. Only images are allowed.";
                } else {
                    $uploadPath = __DIR__ . '/../../storage/uploads/';
                    $filename = hash('sha256', $fileContent . time()) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                    $targetPath = $uploadPath . $filename;
                    
                    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                        // SECURE: Store hash for integrity verification
                        $message = "File uploaded successfully (SECURE: Hash verified)";
                        $uploadedFile = [
                            'name' => $filename,
                            'size' => $file['size'],
                            'hash' => $fileHash,
                            'mime_type' => $mimeType
                        ];
                    } else {
                        $message = "Upload failed";
                    }
                }
            }
        }

        $this->render('a08/secure', [
            'message' => $message,
            'uploadedFile' => $uploadedFile,
            'fileHash' => $fileHash
        ]);
    }
}
